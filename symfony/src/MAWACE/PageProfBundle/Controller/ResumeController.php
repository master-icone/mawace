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
		
		$statut = $repositoryArchiveUser->findOneBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));
		$idStatut = $statut->getIdStatut();
		$potentielBrut = $repositoryStatut->find($idStatut);
		$valeurPB = $potentielBrut->getPotentielBrut();
		$decharge = $repositoryArchiveUser->findOneByidUtilisateur($idUser);
		$valeurDecharge = $decharge->getDecharge();
		$valeurPN = $valeurPB-$valeurDecharge;
		$heures = $repositoryHeuresAffectees->findBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));//tableau avec les heures CM, TD, TP dans les UEs de l'utilisateurs
		
		foreach($heures as $heure)
		{
			$Cours = $repositoryCours->findByid($heure->getIdCours());// tableau des cours (type(cm, td, tp) et UE correspondante)
			foreach($Cours as $cours)
			{
				$UEs[$cours->getIdUE()] = $repositoryUE->findByid($cours->getIdUE()); //Stockage des UEs
				$typeId = $cours->getIdTypeCours(); //Id du type du cours
				$type = $repositoryTypeCours->findOneByid($typeId); //Récupération du type
				$typenom = $type->getNom(); //Récupération du nom du type (CM, TD, TP...)
				
					$coeffsSupp[$typeId] = $repositoryCoeffSupp->findOneBy(array('idTypeCours'=> $typeId, 'idStatut'=> $idStatut)); //Récupération du coefficient correspondant en fonction du statut
				
					$coeffs[$typeId] = $repositoryCoeff->findOneBy(array('idTypeCours'=> $typeId, 'idStatut'=> $idStatut));
				
				if($typenom == "CM"){ //Si c'est un CM								
					$sommeCM = $sommeCM+(float)$heure->getNbHeures(); //Ajout à la somme des heures CM	
					$u[$cours->getIdUE()]["CM"] = $heure->getNbHeures(); //Stockage des heures de CM à l'UE correspondante
				}
				if($typenom == "TD"){ //Si c'est un TD
					$sommeTD = $sommeTD+(float)$heure->getNbHeures();
					$u[$cours->getIdUE()]["TD"]= $heure->getNbHeures();
				}
				if($typenom == "TP"){ //SI c'est un TP
					$sommeTP = $sommeTP+(float)$heure->getNbHeures();
					$u[$cours->getIdUE()]["TP"] = $heure->getNbHeures();
				}
				
				if($typenom != "CM" && $typenom != "TD" && $typenom != "TP"){
					$sommeAutre = $sommeAutre+(float)$heure->getNbHeures();
					$u[$cours->getIdUE()]["AUTRE"] = $heure->getNbHeures();
				}
				
				
				
			}
			
		}
		$total = $sommeCM+$sommeTD+$sommeTP+$sommeAutre;
		$typeCours = array($sommeCM, $sommeTD, $sommeTP, $sommeAutre);
		
		$potentielRestant = $valeurPN;
		for($i=0; $i < strlen($ordre); $i++)
		{
			$coeff = (float)$coeffs[substr($ordre,$i,1)]->getCoeff();
			$coeffSupp = (float)$coeffsSupp[substr($ordre,$i,1)]->getCoeff();
			
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
            "data" => array(
                array('CM', $sommeCM),
                array('TD', $sommeTD),
                array('TP', $sommeTP),
                array('Autre', $sommeAutre)
                    ),
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

		
		return $this->render('MAWACEPageProfBundle:Resume:view.html.twig', array('linechart' => $ob,'user' => $user, 'horsService' => $HorsService, 'heuresUEs' => $u, 'UEs' => $UEs, 'total' => $total, 'totalCoeff' => $totalCoeff));
			
			
		
		
	}
  

}