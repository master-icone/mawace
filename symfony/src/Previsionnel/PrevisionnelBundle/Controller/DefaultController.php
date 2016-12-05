<?php

namespace Previsionnel\PrevisionnelBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Previsionnel\PrevisionnelBundle\Forms\Prevision;
use Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees;

class DefaultController extends Controller
{
	public function indexAction(Request $request)
	{
		$prevision = new Heuresaffectees();
		$now = new \DateTime("now");
		$now = $now->format("Y");
		$anneeScolaire = $now."-".($now + 1);
		$prevision->setAnnee($anneeScolaire);

		$form = $this->createForm(Prevision::class, $prevision);

		$form->handleRequest($request);

		if ($form->isSubmitted() && $form->isValid()) {

			$ucvalide = true;
			$em = $this->getDoctrine()->getManager();
			$prevision = $form->getData();
			
			// Réaffecter les valeurs des champs à autocomplétion
			
			$cours = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Cours')->findOneBy([
				"idue" => $form->get('ue')->getData()->getId(),
				"idtypecours" => $form->get('typecours')->getData()->getId()
			]);
			
			$prevision->setIdutilisateur($prevision->getIdutilisateur()->getId());
			$prevision->setIdcours($cours->getId());

			// On verifie si le prof et le cours existent.

			$utilisateur = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Utilisateurs')->findOneBy([
				"id" => $prevision->getIdutilisateur()
			]);

			if (empty($utilisateur)) {
				echo "Cet utilisateur n'existe pas.";
				$ucvalide = false;
			}

			$cours = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Cours')->findOneBy([
				"id" => $prevision->getIdcours()
			]);

			if (empty($cours)) {
				echo "Ce cours n'existe pas.";
				$ucvalide = false;
			}

			if ($ucvalide) {

				// Si le formulaire est de type "Ajout"

				if ($form->get("ajouter")->isClicked()) {
					$entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
						"idutilisateur" => $prevision->getIdutilisateur(),
						"idcours" => $prevision->getIdcours()
					]);

					if (!empty($entities)) {
						$countHeures = $prevision->getNbHeures();
						foreach ($entities as $entity) {
							$countHeures += $entity->getNbHeures();
							$em->remove($entity);
							$em->flush();
						}

						$prevision->setNbHeures($countHeures);
					}

					$em->persist($prevision);
					$em->flush();

					echo "Vous venez d'ajouter ".$prevision->getNbHeures()." dans le cours ".$prevision->getIdcours()." à l'utilisateur ".$prevision->getIdutilisateur().".";
				}

				// Si le formulaire est de type "Modification"

				if ($form->get("modifier")->isClicked()) {
					$entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
						"idutilisateur" => $prevision->getIdutilisateur(),
						"idcours" => $prevision->getIdcours()
					]);

					foreach ($entities as $entity) {
						$em->remove($entity);
						$em->flush();
					}

					$em->persist($prevision);
					$em->flush();

					echo "Vous venez de modifier : ".$prevision->getNbHeures()." dans le cours ".$prevision->getIdcours()." à l'utilisateur ".$prevision->getIdutilisateur().".";
				}

				// Si le formulaire est de type "Suppression"

				if ($form->get("supprimer")->isClicked()) {
					$entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Heuresaffectees')->findBy([
						"idutilisateur" => $prevision->getIdutilisateur(),
						"idcours" => $prevision->getIdcours()
					]);

					foreach ($entities as $entity) {
						$em->remove($entity);
						$em->flush();
					}

					echo "Vous venez de supprimer le cours ".$prevision->getIdcours()." à l'utilisateur ".$prevision->getIdutilisateur().".";
				}
			}
		}

		return $this->render("PrevisionnelBundle:Default:index.html.twig", array(
			"form" => $form->createView(),
		));
	}

	// ==================== Autocomplete functions ==================== //

	// Autocomplete : Nom du professeur

	public function searchUtilisateursAction(Request $request)
	{
		$nom = $request->query->get('term');
		$nom = strtolower($nom);
		$nom = explode(" ", $nom, 2);

		if (count($nom) == 2) {
			$results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Utilisateurs')->createQueryBuilder('u')
				->where('LOWER(u.nom) LIKE :nom')
				->orWhere('LOWER(u.prenom) LIKE :prenom')
				->setParameter('nom', '%'.$nom[0].'%')
				->setParameter('prenom', '%'.$nom[1].'%')
				->getQuery()
				->getResult();
		}
		else {
			$results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Utilisateurs')->createQueryBuilder('u')
				->where('LOWER(u.nom) LIKE :nom')
				->setParameter('nom', '%'.$nom[0].'%')
				->getQuery()
				->getResult();
		}

		return $this->render('PrevisionnelBundle:Default:autocomplete-professeur.html.twig', ['results' => $results]);
	}

	// Autocomplete : Nom du professeur

	public function getUtilisateursAction($id = null)
	{
		$utilisateur = $this->getDoctrine()->getRepository('PrevisionnelBundle:Utilisateurs')->find($id);

		return new Response($utilisateur->getIdutilisateur());
	}

	// Autocomplete : Nom de l'UE

	public function searchUeAction(Request $request)
	{
		$ue = $request->query->get('term');
		$ue = strtolower($ue);

		$results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Ue')->createQueryBuilder('u')
			->where('LOWER(u.nom) LIKE :nom')
			->setParameter('nom', '%'.$ue.'%')
			->getQuery()
			->getResult();

		return $this->render('PrevisionnelBundle:Default:autocomplete-ue.html.twig', ['results' => $results]);
	}

	// Autocomplete : Nom de l'UE

	public function getUeAction($id = null)
	{
		$ue = $this->getDoctrine()->getRepository("PrevisionnelBundle:Ue")->find($id);

		return new Response($ue->getId());
	}

	// Autocomplete : Nom du type de cours

	public function searchTypecoursAction(Request $request)
	{
		$typecours = $request->query->get('term');
		$typecours = strtolower($typecours);

		$results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Typecours')->createQueryBuilder('t')
			->where('LOWER(t.nom) LIKE :nom')
			->setParameter('nom', '%'.$typecours.'%')
			->getQuery()
			->getResult();

		return $this->render('PrevisionnelBundle:Default:autocomplete-typecours.html.twig', ['results' => $results]);
	}

	// Autocomplete : Nom du type de cours

	public function getTypecoursAction($id = null)
	{
		$typecours = $this->getDoctrine()->getRepository("PrevisionnelBundle:Typecours")->find($id);

		return new Response($typecours->getId());
	}
}