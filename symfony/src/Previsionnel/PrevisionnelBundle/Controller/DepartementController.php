<?php


namespace Previsionnel\PrevisionnelBundle\Controller;


use Previsionnel\PrevisionnelBundle\Entity\Departements;
use Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs;
use Previsionnel\PrevisionnelBundle\Forms\DepartementsType;
use Previsionnel\PrevisionnelBundle\Forms\AffectationDepartements;
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
            $formDep = $this->createForm(DepartementsType::class, $departements);


            $archiveUt=new Archiveutilisateurs();
            $formAffect=$this->createForm(AffectationDepartements::class, $archiveUt);
    

            $formDep->handleRequest($request);
            $formAffect->handleRequest($request);


/********** formulaire d'ajout, modification et supression de departement ************/
            if($formDep->issubmitted() && $formDep->isValid()){
                $em = $this->getDoctrine()->getManager();

                if ($formDep->get("ajouter")->isClicked()) {
                    $departements->setNom($formDep->get('nouveauNom')->getData());

                    $em->persist($departements);
                    $em->flush();

                    $this->addFlash(
                        'success',
                        'Département ajouté'
                    );
                    return $this->redirectToRoute('previsionnel_departement');

                }



                if ($formDep->get("supprimer")->isClicked()){
                    if(!empty($formDep->get('nom')->getData())){
                        $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findById([
                            "nom" => $formDep->get('nom')->getData()->getId()
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



                if($formDep->get("modifier")->isClicked()){
                    if(!empty($formDep->get('nom')->getData())){
                        $entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findById([
                            "nom" => $formDep->get('nom')->getData()->getId()
                        ]);

                        if(!empty($entities)){
                            foreach ($entities as $entity) {
                                $entity->setNom($formDep->get('nouveauNom')->getData());
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



/********** formulaire d'affectation d'un professeur a un departement ************/
            if($formAffect->issubmitted() && $formAffect->isValid()){

                if ($formAffect->get("affecter")->isClicked()) {


                    if(!empty($formAffect->get('idutilisateur')->getData())){
                        $entProf = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs')->findById([
                            "idutilisateur" => $formAffect->get('idutilisateur')->getData()->getId()
                        ]);

                        $entDep= $em->get

                        if(!empty($entProf) && $entProf!=null){
                            foreach ($entProf as $ent) {
                                $ent->setIddepartement($formAffect->get('departement')->getData()->getId());
                            }
                            $this->addFlash('succesAffect','Département affecté');
                            $em->flush();

                        }
                        else{
                            $this->addFlash('echecAffect','Professeur ou département non existant');
                        }



                    return $this->redirectToRoute('previsionnel_departement');

                    }
                }

            }




            $content = $this
                ->get('templating')
                ->render('PrevisionnelBundle:Departement:index.html.twig',array('formDep'=> $formDep->createView(),
                                                                                'formAffect'=>$formAffect->createView(),
                                                                                "utilisateur" => $utilisateur,
                                                                                "roles" => $listeRoles,
                                                                                "annee" => $anneeScolaire));

            return new Response($content);
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





    // Autocomplete : Nom du departement
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

    // Autocomplete : departement

    public function getDepartementAction($id = null)
    {
        return new Response($id);
    }







}