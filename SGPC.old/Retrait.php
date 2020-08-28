<?php date_default_timezone_set("Europe/Paris");

//Cette partie gère les retraits des utilisateurs.
 
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
			// Cette fonction permet l'affichage de toute la partie concernant les caractéristiques de chauqe produit
		
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
			
			$mess = $mess.$etat."&nbsp&nbsp&nbsp <strong> Pureté :</strong> ".$row['Purete']."<br/><br/></center>";
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
			$mess = $mess."<center>Résumé des phrases de risques : <a href = \"phrase risque.pdf\"><img src=\"Images/pdf.jpg\" alt=\"Document\" /></a></center>";
			
			$mess = $mess."<br/><hr><br/><center> <strong>Propriétaire : </strong>";
			

			$proprio = $row['ID'];
			if ($proprio == null) {
				$proprio = "Aucun";
			}
			$mess = $mess.$proprio."<br/><strong>Lieu de stockage :</strong> ";
			
						$req_l = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
			$req_l -> execute(array($row['Id_lieu']));
			$lieu = "";
			foreach($req_l as $row6) {
				$lieu = $row6['Nom_lieu'];
			}
			
			$req_sl = $bdd->prepare('SELECT * FROM Etagere WHERE Etagere = ?');
			$req_sl -> execute(array($row['Etagere']));
			foreach($req_sl as $row7) {
				$lieu = $lieu." ".$row7['Nom_Etagere'];
			}

			$mess = $mess.$lieu."<strong>&nbsp&nbsp en quantité :</strong> ".$row['Quantite']." g OU mL </center>";


			return $mess;
		}
	}

	
	
	
	
	
	
if (isset($_GET['id'])) {
	$mess = $mess.affichage_produit($_GET['id'],$bdd);
	$mess = $mess."<br/><hr><br/><center><form action=\"Produits/Retrait.php?id=".$_GET['id']."\" method=\"post\">
		<strong>Quantité à retirer *</strong>
		<input type=\"text\" name=\"Quantite\" required=\"required\" />
		 <strong>g OU mL</strong></center>";
		
	$util = $bdd->prepare('SELECT * FROM utilisations');
	$util -> execute();
	$mess = $mess."<br/><center><strong>Utilisation faite *	: </strong><select name=\"Id_utilisation\">";
	$mess = $mess."<option value=\"0\" ></option>";
	foreach($util as $row) {
			$id = $row['Id_utilisation'];
			$intitule = $row['Intitule_uti'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
		}
	
	$mess = $mess."</select>&nbsp<strong>Temps d'utilisation *</strong> : <input type=\"text\" name=\"Temps\" required=\"required\"/> en minutes&nbsp";

	

	
	$ris = $bdd->prepare('SELECT * FROM risques order by Intitule_ris');
	$ris -> execute();

	$mess = $mess."<br/><br/><table width=85%><th>Risques présents simultanément</th><th>Protection individuelles</th><th>Protections communes</th>
	<tr><td><p class=\"cadrechoix\">";
		foreach($ris as $row) {
		$mess = $mess."<input type=\"checkbox\" name=\"Risque".$row['Id_risque']."\" id=\"".$row['Id_risque']."\" /> <label>".$row['Intitule_ris']."</label><br/>";
	}
	$mess = $mess."</p></td>";
	
	
	

	
		
	$epi = $bdd->prepare('SELECT * FROM protection_indi order by Nom_Pro');
	$epi -> execute();

	$mess = $mess."<td><p class=\"cadrechoix\">";

	foreach ($epi as $row) {

		$mess = $mess."<input type=\"checkbox\" name=\"PI".$row['ID_ProIn']."\" id=\"".$row['ID_ProIn']."\" /> <label>".$row['Nom_Pro']."</label><br/>";
		
	}
	$mess = $mess."</p></td>";



	$epc = $bdd->prepare('SELECT * FROM protection_comm order by Nom_Prot');
	$epc -> execute();

	
	$mess = $mess."<td><p class=\"cadrechoix\">";

	foreach ($epc as $row) {

		$mess = $mess."<input type=\"checkbox\" name=\"PC".$row['Id_protC']."\" id=\"".$row['Id_protC']."\" /> <label>".$row['Nom_Prot']."</label><br/>";
		
	}
	$mess = $mess."</p></td></tr></table><br/>";
	
	
	$mess = $mess."<br/><center><strong>Commentaires :</strong> <input type=\"text\" name=\"Commentaire\" maxlength=\"100\"/></center>";
	
	
	$mess = $mess."<center><br/><br/><input type=\"submit\" value = \"Retirer\" />
	</form></center><br/>";
	

} else {
	if (isset($_POST['ID_Produit'])) {
		echo '<script>window.location.replace("Retrait.php?id='.$_POST['ID_Produit'].'");</script>';
	} else {
	
			
	$mess ="<br/><form action=\"Retrait.php\" method=\"post\">
		<center>Produits a selectionner triés par ordre alphabétique : &nbsp<br/>
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits ORDER BY Nom_Produit');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour le choix.
		
		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$purete = $row['Purete'];
			if ($purete == "") {
				$purete = "N/A";
			}
			$intitule = $row['Nom_Produit']."&nbsp&nbsp&nbsp Num_Cas : ".$row['Num_Cas']."  &nbsp&nbsp&nbsp&nbsp&nbspPurete : ".$purete."&nbsp&nbsp&nbsp&nbsp ";
			

			$intitule = $intitule." Proprietaire : ";
			if (!($row['ID'] == null )) {
				$intitule = $intitule.$row['ID'];
				
			} else {
				$intitule = $intitule." N/A &nbsp&nbsp&nbsp";
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbspEntreposé dans : ".$nom_lieu."";
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
		$mess = $mess."<br/><br/><input type=\"submit\" value = \"Selection\"> </select></form>";
				//Tri par numéro cas
		
		 	$mess =  $mess."<br/><form action=\"Retrait.php\" method=\"post\">
		<br/> Produit a selectionner trié par numéro Cas :<br/> &nbsp
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits ORDER By Num_Cas');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour le choix.
		
		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$purete = $row['Purete'];
			if ($purete == "") {
				$purete = "N/A";
			}
			$intitule = "Numéro CAS : ".$row['Num_Cas']."&nbsp&nbsp&nbsp".$row['Nom_Produit']."  &nbsp&nbsp&nbsp&nbsp&nbspPurete : ".$purete."&nbsp&nbsp&nbsp&nbsp ";
			

			$intitule = $intitule." Proprietaire : ";
			if (!($row['ID'] == null )) {
				$intitule = $intitule.$row['ID'];			} else {
				$intitule = $intitule." N/A &nbsp&nbsp&nbsp";
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbspEntreposé dans : ".$nom_lieu;
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
			
			// Validation
			$mess = $mess."</select><input type=\"submit\" value = \"Selection\" /></form></center><br/>";
	
	}
	
}



include "Base.php";


?>