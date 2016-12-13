<?php

namespace Previsionnel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AccueilController extends Controller
{
    public function indexAction()
    {
        $user = $this->getUser();

        $now = new \DateTime("now");
        $now = $now->format("Y");
        $anneeScolaire = $now."-".($now + 1);

        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Utilisateurs')->findOneBy([
            "login" => $user
        ]);

        $statut = null;
        $listeRoles = array();
        if (!empty($utilisateur)) {
            $archive = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Archiveutilisateurs')->findOneBy([
                "idutilisateur" => $utilisateur->getId(),
                "annee" => $anneeScolaire
            ]);
            
            if (!empty($archive)) {
                $statut = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Statut')->findOneBy([
                    "id" => $archive->getIdstatut()
                ]);
                
                if (!empty($statut)) {
                    $statut = $statut->getNom();
                }
                
                $rolesExploded = explode("/", $archive->getIdrole());
                
                foreach($rolesExploded as $idrole) {
                    $role = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Roles')->findOneBy([
                        "id" => $idrole
                    ]);
                    
                    array_push($listeRoles, $role->getNom());
                }
            }
        }

        return $this->render("PrevisionnelUserBundle:Accueil:accueil.html.twig", [
            "utilisateur" => $utilisateur,
            "statut" => $statut,
            "roles" => $listeRoles
        ]);
    }
}