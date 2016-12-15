<?php

namespace Previsionnel\PrevisionnelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Previsionnel\PrevisionnelBundle\Forms\Coefficients;
use Previsionnel\PrevisionnelBundle\Entity\Coefficientsnormaux;
use Previsionnel\PrevisionnelBundle\Entity\Coefficientssupplementaires;

class CoefficientsController extends Controller
{
    public function coefficientsAction(Request $request)
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

        //if (in_array("Affectation des coefficients", $listeRoles)) {
            $coefficient = new Coefficientsnormaux();
            $coefficient->setAnnee($anneeScolaire);

            $form = $this->createForm(Coefficients::class, $coefficient);

            $form->handleRequest($request);

            if ($form->isSubmitted() && $form->isValid()) {
                $coefficient = $form->getData();

                if ($form->get("ajouter")->isClicked()) {

                    return $this->redirectToRoute("previsionnel_coefficients");
                }

                // Si le formulaire est de type "Modification"

                else if ($form->get("modifier")->isClicked()) {

                    return $this->redirectToRoute("previsionnel_coefficients");
                }

                // Si le formulaire est de type "Suppression"

                else if ($form->get("supprimer")->isClicked()) {

                    return $this->redirectToRoute("previsionnel_coefficients");
                }
            }

            return $this->render("PrevisionnelBundle:Coefficients:coefficients.html.twig", array(
                "form" => $form->createView(),
                "utilisateur" => $utilisateur,
                "roles" => $listeRoles,
                "annee" => $anneeScolaire
            ));
        /*}
        else {
            return $this->redirectToRoute("previsionneluser_accueil");
        }*/
    }

    // ==================== Autocomplete functions ==================== //

    // Autocomplete : Nom de l'UE

    public function searchStatutAction(Request $request)
    {
        $statut = $request->query->get('term');
        $statut = strtolower($statut);

        $results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Statut')->createQueryBuilder('s')
            ->where('LOWER(s.nom) LIKE :nom')
            ->setParameter('nom', '%'.$statut.'%')
            ->getQuery()
            ->getResult();

        return $this->render('PrevisionnelBundle:Coefficients:autocomplete-statut.html.twig', ['results' => $results]);
    }

    // Autocomplete : Nom de l'UE

    public function getStatutAction($id = null)
    {
        return new Response($id);
    }
}