<?php


namespace Previsionnel\PrevisionnelBundle\Controller;


use Previsionnel\PrevisionnelBundle\Entity\Departements;
use Previsionnel\PrevisionnelBundle\Forms\DepartementsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DepartementController extends Controller
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

        if (in_array("Affectation des départements", $listeRoles)) {
            $departements = new Departements();
            $form = $this->createForm(DepartementsType::class, $departements);
            $form->handleRequest($request);


            if($form->issubmitted() && $form->isValid()){
                $em = $this->getDoctrine()->getManager();

                if ($form->get("ajouter")->isClicked()) {
                    $departements->setNom($form->get('nouveauNom')->getData());

                    $em->persist($departements);
                    $em->flush();

                    $this->addFlash(
                        'success',
                        'Département ajouté'
                    );
                    return $this->redirectToRoute('previsionnel_departement');

                }



                if ($form->get("supprimer")->isClicked()){
                    if(!empty($form->get('nom')->getData())){
                        $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findById([
                            "nom" => $form->get('nom')->getData()->getId()
                        ]);
                        

                        if (!empty($entities)&& $entities!=null) {
                            foreach ($entities as $entity) {
                                $em->remove($entity);
                                $em->flush();	        
                            }
                            $this->addFlash(
                                'success',
                                'Département supprimé'
                            );
                        }
                    }
                    else{
                        $this->addFlash(
                            'echec',
                            'Ce département n\'est pas présent dans la base'
                        );

                    }

                    return $this->redirectToRoute('previsionnel_departement');

                }



                if($form->get("modifier")->isClicked()){
                    if(!empty($form->get('nom')->getData())){
                        $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findById([
                            "nom" => $form->get('nom')->getData()->getId()
                        ]);

                        if(!empty($entities)){
                            foreach ($entities as $entity) {
                                $entity->setNom($form->get('nouveauNom')->getData());
                            }
                        }
                        $em->flush();
                        $this->addFlash(
                            'success',
                            'Département modifié'
                        );
                    }
                    else{
                        $this->addFlash(
                            'echec',
                            'Ce département n\'est pas présent dans la base'
                        );
                    }


                    return $this->redirectToRoute('previsionnel_departement');

                }



            }


            $content = $this
                ->get('templating')
                ->render('PrevisionnelBundle:Departement:index.html.twig',array('form'=> $form->createView(),
                                                                                "utilisateur" => $utilisateur,
                                                                                "roles" => $listeRoles,
                                                                                "annee" => $anneeScolaire));

            return new Response($content);
        }
        else {
            return $this->redirectToRoute("previsionneluser_accueil");
        }
    }




    public function searchDepartementAction(Request $request)
    {
        $typecours = $request->query->get('term');
        $typecours = strtolower($typecours);

        $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Departements')->createQueryBuilder('t')
            ->where('LOWER(t.nom) LIKE :nom')
            ->setParameter('nom', '%'.$typecours.'%')
            ->getQuery()
            ->getResult();

        return $this->render('PrevisionnelBundle:Departement:autocomplete-departements.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom du type de cours

    public function getDepartementAction($id = null)
    {
        return new Response($id);
    }







}