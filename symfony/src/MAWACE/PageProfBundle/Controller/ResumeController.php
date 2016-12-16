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
		
			$total = 0; //Total des heures sans coefficient
			$totalCoeff = 0; //Total des heures avec coefficient
			$HorsService = 0; //Total des heures hors-service
		
			$idUser = $id; //Récupération de l'id de l'utilisateur
			
			$manager = $this->getDoctrine()->getManager(); //Récupération du manager courant
			
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
			//Erreur si l'utilisateur n'est pas dans la base de données
			if($user == null) { return new Response("<h1>Cet utilisateur n'existe pas</h1>");}
			
			//On récupère l'archive de l'utilisateur courant
			$archive = $repositoryArchiveUser->findOneBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));
			//Erreur si aucune archive n'est trouvée
			if($archive == null) { return new Response("<h1>Aucune archive pour ".$user->getPrenom()." ".$user->getNom()." sur l'année ".$annee."</h1>");}
		
			$idStatut = $archive->getIdStatut(); //Récupération de l'id statut de l'utilisateur
			$statut = $repositoryStatut->find($idStatut); //Récupération du statut
			$ordre = $statut->getOrdreCours(); //Récupération de l'ordre de prise en compte des coefficients
			$valeurPB = $statut->getPotentielBrut(); //Récupération du potentiel brut
			$valeurDecharge = $archive->getDecharge(); //Récupération de la décharge
			$valeurPN = $valeurPB-$valeurDecharge; //Calcul du potentiel net
			$heures = $repositoryHeuresAffectees->findBy(array('idUtilisateur'=>$idUser, 'annee' => $annee));//tableau avec les heures de l'utilisateurs
			
			$coeffsSupp = $repositoryCoeffSupp->findBy(array('idStatut'=> $idStatut, 'annee' => $annee)); //Récupération du coefficient supplémentaires correspondant en fonction du statut	et de l'année
			$coeffs = $repositoryCoeff->findBy(array('idStatut'=> $idStatut, 'annee' => $annee)); //Récupération du coefficient correspondant en fonction du statut et de l'année
			$types = $repositoryTypeCours->findAll(); //Récupération de tous les types de cours existants
			
			$sommes = array(); //Ce tableau associatif contiendra les sommes totales des heures pour chaque type de cours
			$UEs = null; //Ce tableau contiendra les UEs de l'utilisateur
			$ue = null; //Tableau associatif d'une UE avec les heures pour chaque type
			
			foreach($types as $type) //Pour chaque type initialisation d'une nouvelle case du tableau $sommes
			{
				$sommes[$type->getNom()] = 0;
			}
			
			foreach($heures as $heure) //Pour chaque heure de l'utilisateur
			{
				$Cours = $repositoryCours->findByid($heure->getIdCours());// tableau des cours (type(cm, td, tp) et UE correspondante)
				foreach($Cours as $cours) //Pour chaque cours
				{
					$UEs[$cours->getIdUE()] = $repositoryUE->findByid($cours->getIdUE()); //Stockage des UEs
					$typeId = $cours->getIdTypeCours(); //Id du type du cours
					$type = $repositoryTypeCours->findOneByid($typeId); //Récupération du type
					$typenom = $type->getNom(); //Récupération du nom du type (CM, TD, TP...)
					$sommes[$typenom] = $sommes[$typenom]+$heure->getNbHeures(); //Somme des heures pour un type de cours
					$ue[$cours->getIdUE()][$typenom] = $heure->getNbHeures(); //Stockage du nombre d'heure pour un type de cours dans une UE spécifique
				}
				
			}
			$total = array_sum($sommes); //Calcul de la somme totale des heures
			
			$typeCours = array(); //Ce tableau contiendra les différents type de cours (CM, TD, TP...)
			$data = array(); //Ce tableau contiendra les données à afficher pour le graphique
			
			foreach($sommes as $type => $somme) //Pour chaque somme d'heures d'un type de cours
			{
				$typeCours[] = $somme; //On stocke la somme dans un tableau
				if($somme !=0) // Si la somme n'est pas nulle
				{
					$data[] = array($type,$somme); //On la stocke, avec le type de cours concerné, dans le tableau data
				}
			}
			
			/*Calcul des heures avec coefficients*/
			
			$potentielRestant = $valeurPN; //Au commencement le potentiel restant de l'utilisateur est égal à son potentiel net
			for($i=0; $i < count($coeffs); $i++) //Pour chaque coefficient...
			{
				$coeff = (float)$coeffs[substr($ordre,$i,1)-1]->getCoeff(); //On stocke la valeur du coefficient correspondant à l'ordre de prise en compte (donc à un type de cours particulier)
				$coeffSupp = (float)$coeffsSupp[substr($ordre,$i,1)-1]->getCoeff(); //On récupère de manière similaire le coefficient supplémentaire
				
				$effectue = $typeCours[substr($ordre,$i,1)-1]*$coeff; //Le service effectué est égal au nombre d'heure du type de cours actuel multiplié par le coefficient correspondant
				if($effectue > $potentielRestant) { //Si le résultat est supérieur au potentiel restant...
					$HorsService = $HorsService+((($effectue-$potentielRestant)/$coeff)*$coeffSupp); // ...alors la différence entre le résultat et le potentiel restant est comptabilisé comme hors service et donc recalculé avec le coefficient correspondant
				}
				if($potentielRestant > 0) $potentielRestant = $potentielRestant-$effectue; //Calcul du potentiel restant
				if($potentielRestant < 0) $potentielRestant = 0;
				$totalCoeff = $totalCoeff+$effectue; //Ajout de l'effectué dans le total des heures avec coefficients
			}
			
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

			$donnees = array(); //Initialisation des données qui seront transmises à la vue
			$donnees['linechart'] = $ob; //Le graphique
			$donnees['user'] = $user; //L'utilisateur
			$donnees['horsService'] = $HorsService; //Le total hors-service
			if($ue != null) //Si elles existent...
			{
				$donnees['heuresUEs'] = $ue; //... les heures des UEs
			}
			if($UEs != null) //Si elle existe...
			{
				$donnees['UEs'] = $UEs; //... la liste des UEs
			}
			$donnees['total'] = $total; //Le total des heures déclarées
			$donnees['totalCoeff'] = $totalCoeff; //Le total du service effectué
			$donnees['utilisateur'] = $utilisateur; //Le repository de l'utilisateur
			$donnees['roles'] = $listeRoles; //La liste des rôles
			$donnees['annee'] = $anneeScolaire;	//L'année courante
			return $this->render('MAWACEPageProfBundle:Resume:view.html.twig', $donnees); //Rendu de la vue
    }
    else {
        return $this->redirectToRoute("previsionneluser_accueil");
    }
			
			
		
		
	}
  

}
