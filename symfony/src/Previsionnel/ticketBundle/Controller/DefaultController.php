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

        if (in_array("Envoyer un ticket", $listeRoles)) {
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

                $this->addFlash(
                    'success',
                    'Ticket ajouté'
                );
                return $this->redirectToRoute('mawaceticket_homepage');

            }

            //generer le HTML du formulaire
            $formView = $form->createView();

            //on rend la vue
            return $this->render('mawaceticketBundle:Default:index.html.twig', [
                'form'=>$formView,
                'utilisateur'=>$utilisateur,
                "roles" => $listeRoles,
                "annee" => $anneeScolaire
            ]);
        }
        else {
            return $this->redirectToRoute("previsionneluser_accueil");
        }
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

        if (in_array("Voir les tickets", $listeRoles)) {
            $ticket = $this->getDoctrine()
                ->getRepository('Previsionnel\ticketBundle\Entity\ticket')
                ->findAll();
            return $this->render('mawaceticketBundle:Default:listeTickets.html.twig', [
                'listeTickets'=>$ticket,
                'utilisateur'=>$utilisateur,
                "roles" => $listeRoles,
                "annee" => $anneeScolaire
            ]);
        }
        else {
            return $this->redirectToRoute("previsionneluser_accueil");
        }
    }

}
