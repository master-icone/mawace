<?php

namespace MAWACE\PageProfBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Ob\HighchartsBundle\Highcharts\Highchart;
use Doctrine\ORM\EntityRepository;

class ResumeController extends Controller
{
	public function viewAction($id)
	{
		$sommeCM = 0;
		$sommeTD = 0;
		$sommeTP = 0;
		$sommeAutre = 0;
		$CMcoeff = 0;
		$TDcoeff = 0;
		$TPcoeff = 0;
		$AUTREcoeff = 0;
		$HorsService = 0;
		
		$idUser = $id;
		$manager = $this->getDoctrine()->getManager();
		// Les différents repositories
		$repositoryUser = $manager->getRepository('MAWACEPageProfBundle:utilisateurs');
		$repositoryHeuresAffectees = $manager->getRepository('MAWACEPageProfBundle:heuresaffectees');
		$repositoryCours = $manager->getRepository('MAWACEPageProfBundle:cours');
		$repositoryTypeCours = $manager->getRepository('MAWACEPageProfBundle:typecours');
		$repositoryUE = $manager->getRepository('MAWACEPageProfBundle:ue');
		$repositoryCoeff = $manager->getRepository('MAWACEPageProfBundle:coefficientsnormaux');
		
		// On récupère l'entité correspondante au idUser
		$user = $repositoryUser->find($idUser);
		$heures = $repositoryHeuresAffectees->findByidUtilisateur($idUser);//tableau avec les heures CM, TD, TP dans les UEs de l'utilisateurs
		foreach($heures as $heure)
		{
			$Cours = $repositoryCours->findByid($heure->getIdCours());// tableau des cours (type(cm, td, tp) et UE correspondante)
			foreach($Cours as $cours)
			{
				$UEs[$cours->getIdUE()] = $repositoryUE->findByid($cours->getIdUE()); //Stockage des UEs
				$typeId = $cours->getIdTypeCours(); //Id du type du cours
				$type = $repositoryTypeCours->findOneByid($typeId); //Récupération du type
				$typenom = $type->getNom(); //Récupération du nom du type (CM, TD, TP...)
				
				if($typenom == "CM"){ //Si c'est un CM								
					$sommeCM = $sommeCM+(float)$heure->getNbHeures(); //Ajout à la somme des heures CM
					$coeff['CM']= $repositoryCoeff->findOneBy(array('idTypeCours'=> $type, 'idStatut'=> $heure->getIdStatut())); //Récupération du coefficient correspondant en fonction du statut
					$CMcoeff = $CMcoeff+(float)$heure->getNbHeures()*(float)$coeff['CM']->getCoeff(); //Calcul CM avec coefficient
					$u[$cours->getIdUE()]["CM"] = $heure->getNbHeures(); //Stockage des heures de CM à l'UE correspondante
				}
				if($typenom == "TD"){ //Si c'est un TD
					$sommeTD = $sommeTD+(float)$heure->getNbHeures();
					$coeff['TD']= $repositoryCoeff->findOneBy(array('idTypeCours'=> $type, 'idStatut'=> $heure->getIdStatut()));
					$TDcoeff = $TDcoeff+(float)$heure->getNbHeures()*(float)$coeff['TD']->getCoeff();
					$u[$cours->getIdUE()]["TD"]= $heure->getNbHeures();
				}
				if($typenom == "TP"){ //SI c'est un TP
					$sommeTP = $sommeTP+(float)$heure->getNbHeures();
					$coeff['TP']= $repositoryCoeff->findOneBy(array('idTypeCours'=> $type, 'idStatut'=> $heure->getIdStatut()));
					$TPcoeff = $TPcoeff+(float)$heure->getNbHeures()*(float)$coeff['TP']->getCoeff();
					$u[$cours->getIdUE()]["TP"] = $heure->getNbHeures();
				}
				
				if($typenom != "CM" && $typenom != "TD" && $typenom != "TP"){
					$sommeAutre = $sommeAutre+(float)$heure->getNbHeures();
					$coeff[$typenom] = $repositoryCoeff->findOneBy(array('idTypeCours'=> $type, 'idStatut'=> $heure->getIdStatut()));
					$Autrecoeff = $Autrecoeff+(float)$heure->getNbHeures()*(float)$coeff[$typenom]->getCoeff();
					$u[$cours->getIdUE()]["AUTRE"] = $heure->getNbHeures();
				}
				
			}
			
		}
		
		$total = $sommeCM+$sommeTD+$sommeTP+$sommeAutre; //Total des heures sans coefficient
		if($total > 192) {$HorsService = $total - 192;}
		$totalCoeff = $CMcoeff+$TDcoeff+$TPcoeff+$AUTREcoeff; //Total des heures avec coeficient

		// Création du graphique
        $sellsHistory = array(
		array(
            "type" => "pie",
            "name" => "Heures totales",
            "data" => array(
                array('CM', $sommeCM),
                array('TD', $sommeTD),
                array('TP', $sommeTP)
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
