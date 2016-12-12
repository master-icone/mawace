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
        
        $em = $this->getDoctrine()->getManager();
        $utilisateur = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Utilisateurs')->findOneBy([
            "login" => $user
        ]);
        
		return $this->render("PrevisionnelUserBundle:Accueil:accueil.html.twig", [
            "utilisateur" => $utilisateur
        ]);
	}
}