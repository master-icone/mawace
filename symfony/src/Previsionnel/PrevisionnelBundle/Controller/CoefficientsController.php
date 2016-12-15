<?php

namespace Previsionnel\PrevisionnelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Previsionnel\PrevisionnelBundle\Forms\Prevision;
use Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees;

class CoefficientsController extends Controller
{
    public function indexAction(Request $request)
    {
        $user = $this->getUser();

        $now = new \DateTime("now");
        $now = $now->format("Y");
        $anneeScolaire = $now."-".($now + 1);

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Utilisateurs')->findOneBy([
            "login" => $user
        ]);

        $listeRoles = array();
        if (!empty($utilisateur)) {
            $archive = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs')->findOneBy([
                "idutilisateur" => $utilisateur->getId(),
                "annee" => $anneeScolaire
            ]);

            if (!empty($archive)) {
                $rolesExploded = explode("/", $archive->getIdrole());

                foreach($rolesExploded as $idrole) {
                    $role = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Roles')->findOneBy([
                        "id" => $idrole
                    ]);

                    array_push($listeRoles, $role->getNom());
                }
            }
        }

        if (in_array("Affectation d'heures de cours", $listeRoles)) {
            $prevision = new Heuresaffectees();
            $prevision->setAnnee($anneeScolaire);

            $form = $this->createForm(Prevision::class, $prevision);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {

                $UtilisateurCoursValides = true;
                $em = $this->getDoctrine()->getManager();
                $prevision = $form->getData();

                $cours = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Cours')->findOneBy([
                    "idue" => $form->get('ue')->getData()->getId(),
                    "idtypecours" => $form->get('typecours')->getData()->getId()
                ]);

                if (empty($cours)) {
                    $this->addFlash("danger", "Ce cours n'existe pas.");
                    $UtilisateurCoursValides = false;
                }

                // On verifie si le prof et le cours existent.

                $utilisateur = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Utilisateurs')->findOneBy([
                    "id" => $prevision->getIdutilisateur()
                ]);

                if (empty($utilisateur)) {
                    $this->addFlash("danger", "Cet utilisateur n'existe pas.");
                    $UtilisateurCoursValides = false;
                }

                if ($UtilisateurCoursValides) {

                    // On réaffecte les valeurs à l'entité car l'autocomplétion renvoie des tableaux

                    $prevision->setIdutilisateur($prevision->getIdutilisateur()->getId());
                    $prevision->setIdcours($cours->getId());

                    // Si le formulaire est de type "Ajout"

                    $statutAutorise = true;

                    $archiveUtilisateurs = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs')->findOneBy([
                        "idutilisateur" => $prevision->getIdutilisateur()
                    ]);

                    $interdictionsStatut = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Interdictionaffectation')->findBy([
                        "idstatut" => $archiveUtilisateurs->getIdstatut()
                    ]);

                    foreach ($interdictionsStatut as $interdiction) {
                        if ($interdiction->getIdtypecours() == $cours->getIdtypecours()) {
                            $statutAutorise = false;
                            break;
                        }
                    }

                    if ($form->get("ajouter")->isClicked()) {
                        if ($statutAutorise) {
                            $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
                                "idutilisateur" => $prevision->getIdutilisateur(),
                                "idcours" => $prevision->getIdcours()
                            ]);

                            $countHeures = $prevision->getNbheures();
                            foreach ($entities as $entity) {
                                $countHeures += $entity->getNbheures();
                                $em->remove($entity);
                                $em->flush();
                            }

                            $limiteHeures = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Limitenbcours')->findOneBy([
                                "idstatut" => $archiveUtilisateurs->getIdstatut(),
                                "idtypecours" => $cours->getIdtypecours()
                            ]);

                            if (!empty($limiteHeures)) {
                                if ($countHeures > $limiteHeures->getNbheures()) {
                                    $countHeures = $limiteHeures->getNbheures();
                                    $this->addFlash("warning", "Nombre d'heures trop élevé pour ce statut, le nombre d'heures affecté a été limité à ".$limiteHeures->getNbheures().".");
                                }
                            }

                            $prevision->setNbheures($countHeures);

                            $em->persist($prevision);
                            $em->flush();
                            
                            $this->addFlash("success", "L'utilisateur dispose désormais de ".$prevision->getNbheures()." heures dans le cours sélectionné.");
                        }
                        else {
                            $this->addFlash("danger", "Impossible d'affecter ce type de cours au statut de cet utilisateur.");
                        }

                        return $this->redirectToRoute("previsionnel_prevision");
                    }

                    // Si le formulaire est de type "Modification"

                    else if ($form->get("modifier")->isClicked()) {
                        if ($statutAutorise) {
                            $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
                                "idutilisateur" => $prevision->getIdutilisateur(),
                                "idcours" => $prevision->getIdcours()
                            ]);

                            foreach ($entities as $entity) {
                                $em->remove($entity);
                                $em->flush();
                            }

                            $limiteHeures = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Limitenbcours')->findOneBy([
                                "idstatut" => $archiveUtilisateurs->getIdstatut(),
                                "idtypecours" => $cours->getIdtypecours()
                            ]);

                            if (!empty($limiteHeures)) {
                                if ($prevision->getNbheures() > $limiteHeures->getNbheures()) {
                                    $prevision->setNbheures($limiteHeures->getNbheures());
                                    $this->addFlash("warning", "Nombre d'heures trop élevé pour ce statut, le nombre d'heures affecté a été limité à ".$limiteHeures->getNbheures().".");
                                }
                            }

                            $em->persist($prevision);
                            $em->flush();
                            
                            $this->addFlash("success", "L'utilisateur dispose désormais de ".$prevision->getNbheures()." heures dans le cours sélectionné.");
                        }
                        else {
                            $this->addFlash("danger", "Impossible d'affecter ce type de cours au statut de cet utilisateur.");
                        }

                        return $this->redirectToRoute("previsionnel_prevision");
                    }

                    // Si le formulaire est de type "Suppression"

                    else if ($form->get("supprimer")->isClicked()) {
                        $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
                            "idutilisateur" => $prevision->getIdutilisateur(),
                            "idcours" => $prevision->getIdcours()
                        ]);

                        if (!empty($entities)) {
                            foreach ($entities as $entity) {
                                $em->remove($entity);
                                $em->flush();
                            }

                            $this->addFlash("success", "La suppression du cours à l'utilisateur s'est bien réalisée");
                        }
                        else {
                            $this->addFlash("danger", "Aucune heure n'était affectée à cet utilisateur pour le cours sélectionné");
                        }

                        return $this->redirectToRoute("previsionnel_prevision");
                    }
                }
            }

            return $this->render("PrevisionnelBundle:Prevision:prevision.html.twig", array(
                "form" => $form->createView(),
                "utilisateur" => $utilisateur,
                "roles" => $listeRoles,
                "annee" => $anneeScolaire
            ));
        }
        else {
            return $this->redirectToRoute("previsionneluser_accueil");
        }
    }

    // ==================== Autocomplete functions ==================== //

    // Autocomplete : Nom du professeur

    public function searchUtilisateursAction(Request $request)
    {
        $nom = $request->query->get('term');
        $nom = strtolower($nom);
        $nom = explode(" ", $nom, 2);

        if (count($nom) == 2) {
            $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Utilisateurs')->createQueryBuilder('u')
                ->where('LOWER(u.nom) LIKE :nom')
                ->orWhere('LOWER(u.prenom) LIKE :prenom')
                ->setParameter('nom', '%'.$nom[0].'%')
                ->setParameter('prenom', '%'.$nom[1].'%')
                ->getQuery()
                ->getResult();
        }
        else {
            $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Utilisateurs')->createQueryBuilder('u')
                ->where('LOWER(u.nom) LIKE :nom')
                ->setParameter('nom', '%'.$nom[0].'%')
                ->getQuery()
                ->getResult();
        }

        return $this->render('PrevisionnelBundle:Prevision:autocomplete-professeur.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom du professeur

    public function getUtilisateursAction($id = null)
    {
        return new Response($id);
    }

    // Autocomplete : Nom de l'UE

    public function searchUeAction(Request $request)
    {
        $ue = $request->query->get('term');
        $ue = strtolower($ue);

        $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Ue')->createQueryBuilder('u')
            ->where('LOWER(u.nom) LIKE :nom')
            ->setParameter('nom', '%'.$ue.'%')
            ->getQuery()
            ->getResult();

        return $this->render('PrevisionnelBundle:Prevision:autocomplete-ue.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom de l'UE

    public function getUeAction($id = null)
    {
        return new Response($id);
    }

    // Autocomplete : Nom du type de cours

    public function searchTypecoursAction(Request $request)
    {
        $typecours = $request->query->get('term');
        $typecours = strtolower($typecours);

        $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Typecours')->createQueryBuilder('t')
            ->where('LOWER(t.nom) LIKE :nom')
            ->setParameter('nom', '%'.$typecours.'%')
            ->getQuery()
            ->getResult();

        return $this->render('PrevisionnelBundle:Prevision:autocomplete-typecours.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom du type de cours

    public function getTypecoursAction($id = null)
    {
        return new Response($id);
    }
}