<?php

namespace Previsionnel\ticketBundle\Controller;

use Previsionnel\ticketBundle\Form\ticketType;
use Previsionnel\ticketBundle\Entity\ticket;

use Previsionnel\ticketBundle\Controller\listeTicketsController;
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


        $user = $this->getUser();

        $em = $this->getDoctrine()->getManager();
        $idUser = $em->getRepository('Previsionnel\ticketBundle\Entity\Utilisateurs')->findOneBy([
            "login" => $user]);



            //cree un ticket
		$ticket = new ticket();
		
		//recuperer le formulaire
		$form = $this->createForm(ticketType::class,$ticket);

        $form->handleRequest($request);

        //si le formulaire a ete soumis
        if($form->isSubmitted() && $form->isValid()){
            //enregistrer en BDD
            $em = $this->getDoctrine()->getManager();
            $ticket->setIdUE($form->get('idUE')->getData()->getId());
            $em->persist($ticket);

            $em->flush();

            return new Response('ticket ajoute !');
        }
		
		//generer le HTML du formulaire
		$formView = $form->createView();
		
		//on rend la vue
        return $this->render('mawaceticketBundle:Default:index.html.twig',array('form'=>$formView,'idUser'=>$idUser->getId()));
    }
    // Autocomplete : Nom de l'UE

    public function searchUeAction(Request $request)
    {
        $ue = $request->query->get('term');
        $ue = strtolower($ue);

        $results = $this->getDoctrine()->getRepository('ticketBundle:Ue')->createQueryBuilder('u')
            ->where('LOWER(u.nom) LIKE :nom')
            ->setParameter('nom', '%'.$ue.'%')
            ->getQuery()
            ->getResult();

        return $this->render('mawaceticketBundle:Default:autocomplete-ue.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom de l'UE

    public function getUeAction($id = null)
    {
        return new Response($id);
    }

    public function listeTicketsAction()
    {
        $ticket = $this->getDoctrine()
            ->getRepository('Previsionnel\ticketBundle\Entity\ticket')
            ->findAll();
        return $this->render('mawaceticketBundle:Default:listeTickets.html.twig',array('listeTickets'=>$ticket));

    }
	
}
