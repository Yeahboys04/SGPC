<?php date_default_timezone_set("Europe/Paris");

// Cette page permet de gérer la consultation des retraits par produits

session_start();
$mess = "";
if ($_SESSION['id'] == 0 ) {
	echo '<script>alert("Vous n\'etes pas connecte");window.location.replace("Accueil.php");</script>';
	
}
if (!($_SESSION['Admin'] == 1)){
	echo '<script>window.location.replace("Fiche_perso.php");<script>';
} else {
		try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	
	}




	if (!isset($_GET['id'])) {
	


	if (isset($_POST['ID_Produit'])) {
		echo '<script>window.location.replace("Adm_Consulter_Retrait.php?id='.$_POST['ID_Produit'].'");</script>';
	} else {
		
		$mess ="<form action=\"Adm_Consulter_Retrait.php\" method=\"post\">
		Produit a selectionner : &nbsp
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
			foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$intitule = $row['Nom_Produit']." Num_Cas : ".$row['Num_Cas']."  Purete : ";
			
			
			 if ($row['Purete'] == "") {
				$intitule = $intitule."N/A";
			} else {
				$intitule = $intitule.$row['Purete'];
			}
			

			$intitule = $intitule."&nbsp&nbspPropriétaire : ";
			
			
			if ($row['ID'] == 0 ) {
				$intitule = $intitule."N/A";
			} else {
				$nom_user = "";
				$req2 = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ?');
				$req2 -> execute(array($row['ID']));
				foreach($req2 as $row2) {
					$nom_user = $row2['NOM'];
					$intitule = $intitule." Proprietaire : ".$nom_user;
				}
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp ".$nom_lieu;
				}
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
		
		$mess = $mess."</select><br/><center><input type=\"submit\" value =\"Consulter les retraits\"></center></form>";
	}
} else {
		$mess = "<center><br/>
			Les derniers retraits effectues pour ce produit sont : ";
	
			
			
		$mess = $mess."<table cellspacing = 30><th>Personne</th><th>Date</th><th>Temps d'utilisation</th><th>Utilisation</th><th>Risques</th><th>Quantite</th><th>Protections</th><th>Commentaire</th>";
		$req = $bdd -> prepare('SELECT * FROM retrait WHERE Id_Produit = ? ORDER BY Date_Retrait DESC');
		$req -> execute(array($_GET['id'] ));
		$compteur = 0;
		foreach ($req as $row) {
			if ($compteur < 10 ) {
				$mess = $mess."<tr><td align=center>";
				$req2 = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ?');
				$req2 -> execute(array($row['ID']));
				foreach ($req2 as $row2) {
					$mess = $mess.$row2['NOM']." ".$row2['Prenom']."</td><td align=center>";
				}
				$mess = $mess.$row['Date_Retrait']."</td><td align=center>";
				$mess = $mess.$row['Temps_utilisation']."</td><td align=center>";
				
				$req3 = $bdd->prepare('SELECT * FROM utilisations WHERE Id_utilisation = ?');
				$req3 -> execute(array($row['Id_utilisation']));
				foreach ($req3 as $row3) {
					$mess = $mess.$row3['Intitule_uti']."</td><td align=center>";
				}


					$risques = $row['Risques'];
				
				$mess = $mess.$risques."</td><td align=center>";
				$mess = $mess.$row['Quantite']."</td><td align=center>";
				$protection = $row['Prot_in']."<br/>".$row['Prot_comm'];
				$mess = $mess.$protection."</td><td align=center>";
				$mess = $mess.$row['Commentaire'];
				$mess = $mess."</td></tr>";
			}
				
		}
			$mess = $mess."</table>";
			

		$mess = $mess."</center>";
		
	}
	include "Base.php";
}


?>