<?php

namespace Previsionnel\ticketBundle\Controller;

use Previsionnel\ticketBundle\Form\ticketType;
use Previsionnel\ticketBundle\Entity\ticket;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class DefaultController extends Controller
{
    /**
     * @param Request $request
     * @return \Symfony\Component\HttpFoundation\Response
     */
    public function indexAction(Request $request)
    {
		//cree un ticket
		$ticket = new ticket();

		
		//recuperer le formulaire
		$form = $this->createForm(ticketType::class,$ticket);

        $form->handleRequest($request);

        //si le formulaire a ete soumis
        if($form->isSubmitted() && $form->isValid()){
            //enregistrer en BDD
            $em = $this->getDoctrine()->getManager();

            $em->persist($ticket);

            $em->flush();

            return new Response('ticket ajoute !');
        }
		
		//generer le HTML du formulaire
		$formView = $form->createView();
		
		//on rend la vue
        return $this->render('mawaceticketBundle:Default:index.html.twig',array('form'=>$formView));
    }
	
}
