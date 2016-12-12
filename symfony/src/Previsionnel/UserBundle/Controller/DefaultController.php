<?php

// src/OC/PlatformBundle/Controller/AdvertController.php

namespace Previsionnel\UserBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DefaultController extends Controller
{
  public function indexAction()
  {
    // Depuis un contrôleur
       // On vérifie que l'utilisateur dispose bien du rôle ROLE_AUTEUR
    if (!$this->get('security.authorization_checker')->isGranted('ROLE_USER')) {
      // Sinon on déclenche une exception « Accès interdit »
      throw new AccessDeniedException('Accès limité aux auteurs.');
    }

    // Ici l'utilisateur a les droits suffisant,
    // on peut ajouter une annonce

$user = $this->getUser();

if (null === $user) {
  // Ici, l'utilisateur est anonyme ou l'URL n'est pas derrière un pare-feu
} else {
  // Ici, $user est une instance de notre classe User
}

    $content = $this
    ->get('templating')
    ->render('PrevisionnelUserBundle:Default:index.html.twig');
    
    return new Response($content);
  }
}