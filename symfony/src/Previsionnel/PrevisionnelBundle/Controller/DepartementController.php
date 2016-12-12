<?php


namespace Previsionnel\PrevisionnelBundle\Controller;


use Previsionnel\PrevisionnelBundle\Entity\Departements;
use Previsionnel\PrevisionnelBundle\Forms\DepartementsType;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Doctrine\DBAL\DriverManager;
use Symfony\Component\Security\Core\Exception\AccessDeniedException;


class DepartementController extends Controller
{
  public function indexAction(Request $request)
  {
	
	$departements = new Departements();
	$form = $this->createForm(DepartementsType::class, $departements);
	$form->handleRequest($request);


	if($form->issubmitted() && $form->isValid()){
		$em = $this->getDoctrine()->getManager();

		if ($form->get("ajouter")->isClicked()) {
			$departements->setNom($form->get('nom')->getData());

			$em->persist($departements);
			$em->flush();
		}



		if ($form->get("supprimer")->isClicked()){
			$entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findBy([
				"nom" => $form->get('nom')->getData()
			]);
		
			if (!empty($entities)) {
				foreach ($entities as $entity) {
					$em->remove($entity);
					$em->flush();
				}
			}
			else{
				echo "Ce departement n'existe pas";
			}
		}

		if($form->get("modifier")->isClicked()){
			$entities = $em->getRepository('Previsionnel\PrevisionnelBundle\Entity\Departements')->findBy([
				"nom" => $form->get('nom')->getData()
			]);

			if(!empty($entities)){
				foreach ($entities as $entity) {
					$entity->setNom($form->get('nouveauNom')->getData());
				}
			}
			$em->flush();

		}



	}













	$content = $this
	->get('templating')
	->render('PrevisionnelBundle:Departement:index.html.twig',array('form'=> $form->createView()));
	
	return new Response($content);
  }



	public function searchDepartementAction(Request $request)
	{
		$typecours = $request->query->get('term');
		$typecours = strtolower($typecours);

		$results = $this->getDoctrine()->getRepository('PrevisionnelBundle:Departements')->createQueryBuilder('t')
			->where('LOWER(t.nom) LIKE :nom')
			->setParameter('nom', '%'.$typecours.'%')
			->getQuery()
			->getResult();

		return $this->render('PrevisionnelBundle:Departement:autocomplete-departements.html.twig', ['results' => $results]);
	}

	// Autocomplete : Nom du type de cours

	public function getDepartementAction($id = null)
	{
		return new Response($id);
	}







}