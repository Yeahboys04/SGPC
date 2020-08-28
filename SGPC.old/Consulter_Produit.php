<?php date_default_timezone_set("Europe/Paris");

//Cette partie g�re les retraits des utilisateurs.
 
session_start();
	$mess = "";

		try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root', 'root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	
	}

	function affichage_produit($id,$bdd) {
			// Cette fonction permet l'affichage de toute la partie concernant les caract�ristiques de chauqe produit
		
		$mess = "";
		$req = $bdd->prepare('SELECT * FROM Produits WHERE Id_Produit = ?');
		$req -> execute(array($id));
		
		foreach ($req as $row) {
			$mess =	$mess."<center><h2> Produit : ".$row['Nom_Produit']."<br/>Numero Cas : ".$row['Num_Cas']."&nbsp <br/>Formule chimique : ".$row['Form_Chimique']."</h2></center><br/><br/>";
			$mess = $mess."<center><strong>Etat : </strong>";
			
			$req_etat = $bdd->prepare('SELECT * FROM etat WHERE Id_etat = ?');
			$req_etat -> execute(array($row['Id_etat']));
			$etat = "";
			foreach ($req_etat as $row2) {
				$etat = $row2['Nom_Etat'];
			}
			
			$mess = $mess.$etat."&nbsp&nbsp&nbsp <strong> Puret� :</strong> ".$row['Purete']."<br/><br/></center>";
			if (!($row['C'] == null)) {
				$mess = $mess.'<strong><center>CANCERIGENE </center></strong>';
			}
			if (!($row['M'] == null)) {
				$mess = $mess.'<strong><center>MUTAGENE </center></strong>';
			}
			if (!($row['R'] == null)) {
				$mess = $mess.'<strong><center>REPROTOXIQUE</center></strong>';
			}
			

			
			
			
			$cmr = $row['C']." / ".$row['M']." / ".$row['R'];

			
			

		

			
			
			
			$mess =	$mess."<center><table cellspacing = 50><th>Phrases de risques</th><th>Conseils</th><th>CMR</th>			<tr><td>".$row['Phrases_risques']."</td><td>".$row['Phrases_conseil']."</td><td>".$cmr."</td></tr></table></center>";
			$mess = $mess."<center><strong>Dangers</strong> <br/><br/>".$row['Symbole']."</center>";
			$mess = $mess."<center>R�sum� des phrases de risques : <a href = \"phrase risque.pdf\"><img src=\"Images/pdf.jpg\" alt=\"Document\" /></a></center>";
			

$mess = $mess."<br/><center><hr><br/><strong>Fournisseur : </strong>".$row['Fournisseur'];


			$mess = $mess."<strong>Propri�taire : </strong>";
			

			$proprio = $row['ID'];
			$mess = $mess.$proprio." &nbsp&nbsp<strong>Stock� dans : </strong>";
			
			$req_l = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
			$req_l -> execute(array($row['Id_lieu']));
			$lieu = "";
			foreach($req_l as $row6) {
				$lieu = $row6['Nom_lieu'];
			}
			$sous_lieu = "";
			$req_sl = $bdd->prepare('SELECT * FROM Etagere WHERE Etagere = ?');
			$req_sl -> execute(array($row['Etagere']));
			foreach ($req_sl as $row7) {
				$sl = $row7['Nom_Etagere'];
			}
			


			$mess = $mess.$lieu." ".$sl."<strong>&nbsp&nbsp en quantit� :</strong> ".$row['Quantite']." g OU mL </center>";


			return $mess;
		}
	}

	
	
	
	
	
	
if (isset($_GET['id'])) {
	$mess = $mess.affichage_produit($_GET['id'],$bdd);
		
	$mess = $mess."<br/>";
	
	

} else {
	if (isset($_POST['ID_Produit'])) {
		echo '<script>window.location.replace("Consulter_Produit.php?id='.$_POST['ID_Produit'].'");</script>';
	} else {
	
			
	$mess ="<br/><form action=\"Consulter_Produit.php\" method=\"post\">
		<center>Produits a selectionner tri�s par ordre alphab�tique : &nbsp<br/>
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits ORDER BY Nom_Produit');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu d�roulant pour le choix.
		
		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$purete = $row['Purete'];
			if ($purete == "") {
				$purete = "N/A";
			}
			$intitule = $row['Nom_Produit']."&nbsp&nbsp&nbsp Num_Cas : ".$row['Num_Cas']."  &nbsp&nbsp&nbsp&nbsp&nbspPurete : ".$purete."&nbsp&nbsp&nbsp&nbsp ";
			

			$intitule = $intitule." Proprietaire : ";
			if ($row['ID'] == null) {
				$intitule = $intitule." N/A";	
			} else {
				$intitule = $intitule.$row['ID'];
			}			


				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbspEntrepos� dans : ".$nom_lieu."";
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
		$mess = $mess."<br/><br/><input type=\"submit\" value = \"Selection\"> </select></form>";
				//Tri par num�ro cas
		
		 	$mess =  $mess."<br/><form action=\"Retrait.php\" method=\"post\">
		<br/> Produit a selectionner tri� par num�ro Cas :<br/> &nbsp
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits ORDER By Num_Cas');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu d�roulant pour le choix.
		
		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$purete = $row['Purete'];
			if ($purete == "") {
				$purete = "N/A";
			}
			$intitule = "Num�ro CAS : ".$row['Num_Cas']."&nbsp&nbsp&nbsp".$row['Nom_Produit']."  &nbsp&nbsp&nbsp&nbsp&nbspPurete : ".$purete."&nbsp&nbsp&nbsp&nbsp ";
			

			$intitule = $intitule." Proprietaire : ";
			if ($row['ID'] == null) {
				$intitule = $intitule." N/A ";
			} else {
				$intitule = $intitule.$row['ID'];
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbspEntrepos� dans : ".$nom_lieu;
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
			
			// Validation
			$mess = $mess."</select><input type=\"submit\" value = \"Selection\" /></form></center><br/>";
	
	}
	
}



include "Base.php";


?>
