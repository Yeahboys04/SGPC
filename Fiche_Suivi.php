<?php date_default_timezone_set("Europe/Paris");

session_start();


		try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
$mess = "";
	$mess =$mess."<img src=\"Images/logo_cnrs.gif\" name=\"logo_cnrs\" width = 15% height = 10% /> 
	<img src=\"Images/univ_lorraine.gif\" name=\"logo_ul\" width = 30%  height = 10% /><br/>
	
	<br/><br/><center><strong>FICHE INDIVIDUELLE D'EXPOSITION AUX PREPARATIONS ET PRODUITS DANGEREUX</strong><br/>
			Conformement a l'Art. R4412-91 et a l'Art R 4412-40 du Code du Travail </center>
			
		Annee : <br/><br/>
		Unite/Service/Laboratoire : <br/><br/>
		<strong>Nom :</strong> ";
		
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ?');
		$req -> execute(array($_GET['id']));
		$nom = "";
		$prenom = "";
		foreach($req as $row) {
			$nom = $row['NOM'];
			$prenom = $row['Prenom'];
		}
		$mess = $mess.$nom."&nbsp&nbsp&nbsp&nbsp&nbsp<strong>Prenom : </strong>".$prenom."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<strong>Matricule :</strong>".$row['Matricule']." &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp &nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
		<strong>Date de naissance :</strong>.".$row['Date_naiss']."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp 
		<strong>Activite :</strong> ".$row['Activite']."&nbsp&nbsp&nbsp<br/><br/>";

		$mess = $mess."
		Fait le : <center><strong>Produits et preparations dangereux</strong></center>
		<table border='1' width = 100% align=\"center\" >
		<th >Nom</th>
		<th>Num CAS</th>
		<th>Categorie <br/>de danger</th>
		<th>Categorie <br/> C/M/R</th>
		<th>Forme <br/>physico-<br/>chimique</th> 
		<th>Technique*</th>
		<th>Moyens de <br/>protection<br/>EPC/EPI*</th>
		<th><br/>Tps<br/>d'exposition/<br/>manipulation**</th>
		<th>Nombre de <br/>manipulation/<br/>periode**</th>
		<th>Risques <br/>presents <br/>simultanement</th>
		<th>Reference<br/>documentaire</th>";
		
		$retrait = $bdd->prepare('SELECT * FROM retrait WHERE ID = ? AND Date_Retrait <= ? AND Date_Retrait >= ? ORDER By Id_Produit,Id_utilisation,Prot_in,Prot_comm,Risques');
			//	AND Date_Retrait < ? AND Date_Retrait > ?'); GERER LES DATES
		
		$annee1;
		$annee2;
		$mois1;
		$mois2;

		
		if ($_POST['choix_date1'] == $_POST['choix_date2']) {
			if ($_POST['choix_mois1'] == $_POST['choix_mois2']) {
				
				$mois1 = $_POST['choix_mois1'];
				$mois2 = $_POST['choix_mois2'];
			} else {
			
				if ($_POST['choix_mois1'] < $_POST['choix_date2'])
				{
					$mois1 = $_POST['choix_mois2'];
					$mois2 = $_POST['choix_mois1'];
				} else {
					$mois1 = $_POST['choix_mois1'];
					$mois2 = $_POST['choix_mois2'];
				}
			}
			$annee1 = $_POST['choix_date1'];
			$annee2 = $_POST['choix_date2'];
		}else {
			if ($_POST['choix_date1'] < $_POST['choix_date2']) {
				$annee1 = $_POST['choix_date2'];
				$mois1 = $_POST['choix_mois2'];
				$annee2 = $_POST['choix_date1'];
				$mois2 = $_POST['choix_mois1'];
			} else {
				$annee1 = $_POST['choix_date1'];
				$mois1 = $_POST['choix_mois1'];
				$annee2 = $_POST['choix_date2'];
				$mois2 = $_POST['choix_mois2'];
			}
		}
		
		$choixdate1 = $annee1."-".$mois1."-1";
		$choixdate2 = $annee2."-".$mois2."-1";
		
		$ligne = "";
		$retrait -> execute(array($_GET['id'],$choixdate1,$choixdate2));
		$idcourante = 0;
		foreach ($retrait as $row) {
			
			
				$use = $bdd->prepare('SELECT * FROM utilisations WHERE Id_utilisation = ?');
				$use -> execute(array($row['Id_utilisation']));
				foreach ($use as $row3) {
					$tech = $row3['Intitule_uti'];
				}
				$epi2 = $row['Prot_in'];
				$epc2 = $row['Prot_comm'];
				$risque2 = $row['Risques'];
	
				
		
		// Si la dernière ID traitée n'est pas la même que l'actuelle ( Produit différent donc)
		if (($idcourante == $row['Id_Produit'] )AND($tech == $technique)AND($epi2 == $epi)AND($epc2 == $epc)AND($risque2 == $risque)) {
			$temps_total = $temps_total + $row['Temps_utilisation'];
			$nbmanip = $nbmanip +1;
			$tps_manip = $temps_total /$nbmanip;
			
			
			
		} else {
			$idcourante = $row['Id_Produit'];
			$mess = $mess.$ligne;
			$produit = $bdd->prepare('SELECT * FROM Produits WHERE Id_Produit = ?');
			$produit -> execute(array($row['Id_Produit']));
			foreach($produit as $row2) {
				$nom_produit = $row2['Nom_Produit'];
				$cas = $row2['Num_Cas'];
				$nom_danger = "";
				if (!($row2['Phrases_risques'] == null)) {
					$nom_danger = $row2['Phrases_risques'];
				}
				
				$cmr = $row2['C']." / ".$row2['M']." / ".$row2['R'];
				
				$form = $bdd->prepare('SELECT * FROM Etat WHERE Id_etat = ?');
				$form -> execute(array($row2['Id_etat']));
				$etat = "";
				foreach ($form as $row3) {
					$etat = $row3['Nom_Etat'];
				}
			}
				$tech = $bdd->prepare('SELECT * FROM utilisations WHERE Id_utilisation = ?');
				$tech -> execute(array($row['Id_utilisation']));
				foreach ($tech as $row3) {
					$technique = $row3['Intitule_uti'];
				}

				$epi = $row['Prot_in'];
				$epc = $row['Prot_comm'];
				
			$temps_total = $row['Temps_utilisation'];
			$nbmanip = 1;
			$tps_manip = $temps_total /$nbmanip;
			$risque = $row['Risques'];
			
		
		}
		$ligne = "<tr><td>".$nom_produit."</td><td>".$cas."</td><td>".$nom_danger."</td><td><center>".$cmr."</center></td><td>".$etat."</td><td>".$technique."</td>
			<td>".$epi."<br/>".$epc."</td><td>".$tps_manip."</td><td>".$nbmanip."</td><td>".$risque."</td><td> N/A  </td> </tr>";
}
			
	


	$mess = $mess.$ligne;
	$mess = $mess."</table><br/>
	* Nature du travail effectué <br/>
	** Duree d'exposition annuelle<br/><br/>
	
	Signature du Directeur pour validation&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp
	Signature de la personne<br/><br/><br/><br/><br/><br/><br/>";


	echo $mess;
	//include "Base.php";





?>