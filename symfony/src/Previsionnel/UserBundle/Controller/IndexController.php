<?php

namespace Previsionnel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;


class IndexController extends Controller
{
    public function indexAction()
    {
        $now = new \DateTime("now");
        $now = $now->format("Y");
        $anneeScolaire = $now."-".($now + 1);

        return $this->render("PrevisionnelUserBundle:Index:index.html.twig", [
            "annee" => $anneeScolaire
        ]);
    }
}