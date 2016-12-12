<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace Previsionnel\PrevisionnelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Previsionnel\PrevisionnelBundle\Forms\Recherche;
use Previsionnel\PrevisionnelBundle\Entity\Utilisateurs;
use Doctrine\DBAL\DriverManager;


class SecretaireController extends Controller
{
    public function indexAction(Request $request)
    {

        $now = new \DateTime("now");
		$now = $now->format("Y");
		$anneeScolaire = $now."-".($now + 1);
        /*Récupération de l'entity manager*/
        $em = $this->getDoctrine()->getManager();
        $conn = $em->getConnection();
        $Utilisateurs = new Utilisateurs();
        $form = $this->createForm(Recherche::class, $Utilisateurs);

        /*Affichage du professeurs recherché*/
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            if($form->get("Rechercher")->isClicked()){
            $Utilisateurs = $form->getData();
            $sql = "SELECT utilisateurs.id, utilisateurs.login, utilisateurs.nom, utilisateurs.prenom,departements.nom as nomDep  FROM utilisateurs
        LEFT JOIN archiveutilisateurs ON utilisateurs.id = archiveutilisateurs.idUtilisateur
        LEFT JOIN departements ON archiveutilisateurs.idDepartement = departements.id WHERE LOWER(utilisateurs.nom) = '".strtolower($Utilisateurs->getNom())."' AND archiveutilisateurs.annee ='".$anneeScolaire."'  ORDER BY nomDep";
            $res = $conn->query($sql);
            $tab =  array();
            $tab  = $res->fetchAll();
            }
        }
        else{

            /*Affichage des professeurs présent dans la BDD*/
            $sql = "SELECT utilisateurs.id, utilisateurs.login, utilisateurs.nom, utilisateurs.prenom,departements.nom as nomDep FROM utilisateurs
        LEFT JOIN archiveutilisateurs ON utilisateurs.id = archiveutilisateurs.idUtilisateur
        LEFT JOIN departements ON archiveutilisateurs.idDepartement = departements.id AND archiveutilisateurs.annee ='".$anneeScolaire."' ORDER BY nomDep";
            $res = $conn->query($sql);
            $tab =  array();
            $tab  = $res->fetchAll();
        }

        $content = $this
            ->get('templating')
            ->render('PrevisionnelBundle:Secretaire:index.html.twig' , array('tableauUtilisateur' => $tab , "form" =>$form->createView() , "annee" => $anneeScolaire ));

        return new Response($content);
    }
}