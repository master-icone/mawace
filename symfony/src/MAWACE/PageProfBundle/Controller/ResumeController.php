<?php

namespace MAWACE\PageProfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Doctrine\ORM\EntityRepository;

class ResumeController extends Controller
{
	public function viewAction($id, $annee)
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
        
        if (in_array("Résumé des cours", $listeRoles)) {
		$sommeCM = 0;
		$sommeTD = 0;
		$sommeTP = 0;
		$sommeAutre = 0;
		$CMcoeff = 0;
		$TDcoeff = 0;
		$TPcoeff = 0;
		$total = 0; //Total des heures sans coefficient
		$totalCoeff = 0; //Total des heures avec coefficient
		$AUTREcoeff = 0;
		$HorsService = 0;
		$supp =0;
		$ordre  = "123";
		
		$idUser = $id;
		
		$manager = $this->getDoctrine()->getManager();
		// Les différents repositories
		$repositoryUser = $manager->getRepository('MAWACEPageProfBundle:utilisateurs');
		$repositoryStatut = $manager->getRepository('MAWACEPageProfBundle:statut');
		$repositoryArchiveUser = $manager->getRepository('MAWACEPageProfBundle:archiveutilisateurs');
		$repositoryHeuresAffectees = $manager->getRepository('MAWACEPageProfBundle:heuresaffectees');
		$repositoryCours = $manager->getRepository('MAWACEPageProfBundle:cours');
		$repositoryTypeCours = $manager->getRepository('MAWACEPageProfBundle:typecours');
		$repositoryUE = $manager->getRepository('MAWACEPageProfBundle:ue');
		$repositoryCoeff = $manager->getRepository('MAWACEPageProfBundle:coefficientsnormaux');
		$repositoryCoeffSupp = $manager->getRepository('MAWACEPageProfBundle:coefficientssupplementaires');
		
		// On récupère l'entité correspondante au idUser
		$user = $repositoryUser->find($idUser);
		if($user == null) { return new Response("<h1>Cet utilisateur n'existe pas</h1>");}
		
		$statut = $repositoryArchiveUser->findOneBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));
		if($statut == null) { return new Response("<h1>Aucune archive pour ".$user->getPrenom()." ".$user->getNom()." sur l'année ".$annee."</h1>");}
		
		$idStatut = $statut->getIdStatut();
		$potentielBrut = $repositoryStatut->find($idStatut);
		$valeurPB = $potentielBrut->getPotentielBrut();
		$decharge = $repositoryArchiveUser->findOneByidUtilisateur($idUser);
		$valeurDecharge = $decharge->getDecharge();
		$valeurPN = $valeurPB-$valeurDecharge;
		$heures = $repositoryHeuresAffectees->findBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));//tableau avec les heures CM, TD, TP dans les UEs de l'utilisateurs
		
		$coeffsSupp = $repositoryCoeffSupp->findBy(array('idStatut'=> $idStatut)); //Récupération du coefficient correspondant en fonction du statut	
		$coeffs = $repositoryCoeff->findBy(array('idStatut'=> $idStatut));
		$types = $repositoryTypeCours->findAll();
		$sommes = array();
		$u = null;
		$UEs = null;
		foreach($types as $type)
		{
			$sommes[$type->getNom()] = 0;
		}
		
		foreach($heures as $heure)
		{
			$Cours = $repositoryCours->findByid($heure->getIdCours());// tableau des cours (type(cm, td, tp) et UE correspondante)
			foreach($Cours as $cours)
			{
				$UEs[$cours->getIdUE()] = $repositoryUE->findByid($cours->getIdUE()); //Stockage des UEs
				$typeId = $cours->getIdTypeCours(); //Id du type du cours
				$type = $repositoryTypeCours->findOneByid($typeId); //Récupération du type
				$typenom = $type->getNom(); //Récupération du nom du type (CM, TD, TP...)
				
				$sommes[$typenom] = $sommes[$typenom]+$heure->getNbHeures();
				$u[$cours->getIdUE()][$typenom] = $heure->getNbHeures();
				
				
			}
			
		}
		$total = array_sum($sommes);
		
		$typeCours = array();
		$data = array();
		foreach($sommes as $type => $somme)
		{
			$typeCours[] = $somme;
			if($somme !=0)
			{
				$data[] = array($type,$somme);
			}
		}
		
		$potentielRestant = $valeurPN;
		for($i=0; $i < count($coeffs); $i++)
		{
			$coeff = (float)$coeffs[substr($ordre,$i,1)-1]->getCoeff();
			$coeffSupp = (float)$coeffsSupp[substr($ordre,$i,1)-1]->getCoeff();
			
			$effectue = $typeCours[substr($ordre,$i,1)-1]*$coeff;
			if($effectue > $potentielRestant) {
				$supp = $supp+((($effectue-$potentielRestant)/$coeff)*$coeffSupp);
			}
			$potentielRestant = $potentielRestant-$effectue; //99.75
			$totalCoeff = $totalCoeff+$effectue; //92.25
		}
		
		$HorsService = $supp;
		

		// Création du graphique
        $sellsHistory = array(
		array(
            "type" => "pie",
            "name" => "Heures totales",
            "data" => $data,
			"size" => 200,
			"showInLegend" => true,
			"dataLabels" => array(
				"enabled" => false
			)
			)
        );

       $ob = new Highchart();
        // ID de l'élement de DOM que vous utilisez comme conteneur
       $ob->chart->renderTo('linechart');
       $ob->title->text(null);
	   $ob->series($sellsHistory);

	$donnees = array();
	   
	   $donnees['linechart'] = $ob;
		$donnees['user'] = $user;
		$donnees['horsService'] = $HorsService;
		if($u != null)
		{
			$donnees['heuresUEs'] = $u;
		}
		if($UEs != null)
		{
			$donnees['UEs'] = $UEs;
		}
		$donnees['total'] = $total;
		$donnees['totalCoeff'] = $totalCoeff;
		$donnees['utilisateur'] = $utilisateur;
		$donnees['roles'] = $listeRoles;
		$donnees['annee'] = $anneeScolaire;	
        return $this->render('MAWACEPageProfBundle:Resume:view.html.twig', $donnees);
    }
    else {
        return $this->redirectToRoute("previsionneluser_accueil");
    }
			
			
		
		
	}
  

}
