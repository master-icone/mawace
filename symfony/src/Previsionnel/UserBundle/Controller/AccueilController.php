<?php

namespace Previsionnel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class AccueilController extends Controller
{
	public function indexAction()
	{
		return $this->render("PrevisionnelUserBundle:Accueil:accueil.html.twig");
	}
}