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



	if (!isset($_POST['ID_Produit'])) {
	
	$mess ="<center><h4>Modification d'un produit</h4><br/><br/><form action=\"Adm_Modifier_Produit.php\" method=\"post\">
		Produit a selectionner (trié par nom): <br/>
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$intitule = $row['Nom_Produit']."  ".$row['Num_Cas']."  Purete : ";
			
			
			 if ($row['Purete'] == "") {
				$intitule = $intitule."N/A";
			} else {
				$intitule = $intitule.$row['Purete'];
			}
			

			$intitule = $intitule."&nbsp&nbspPropriétaire : ";
			
			
			if ($row['ID'] == null ) {
				$intitule = $intitule."N/A";
			} else {
				$intitule = $intitule.$row['ID'];
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule."&nbsp&nbspEntreposé dans :  ".$nom_lieu;
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
		
		$mess = $mess."</select><input type=\"submit\" value =\"Modifier\"></form></center>";

				//Tri par numéro cas
		
		 	$mess =  $mess."<br/><center><form action=\"Adm_Modifier_Produit.php\" method=\"post\">
		<br/>Trié par numéro Cas :<br/> &nbsp
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
			$intitule =$row['Num_Cas']."&nbsp&nbsp&nbsp".$row['Nom_Produit']."  &nbsp&nbsp&nbsp&nbsp&nbspPurete : ".$purete."&nbsp&nbsp&nbsp&nbsp ";
			

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
					$intitule= $intitule."&nbsp&nbspEntreposé dans : ".$nom_lieu;
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
			
			// Validation
			$mess = $mess."</select><input type=\"submit\" value = \"Modifier\" /></form></center><br/>";
	
	



} else {
// Cette partie servira à gérer le module permettant d'entrer un nouveau produit dans la base de données.




$id = $_POST['ID_Produit'];
$produit = $bdd -> prepare ('SELECT * FROM produits WHERE Id_Produit = ?');
$produit -> execute(array($id));
foreach ($produit as $row) {




$mess =  " <center><strong> Modification d'un  produit. </strong></center><br/>";

$mess =  $mess."<center><table cellspacing=50 >";

$mess = $mess."<form action=\"Produits/Modif_Produit.php?id=".$id."\" method=\"post\"><tr><td alig=right>
		Nom du produit* : &nbsp
		<input type=\"text\" name=\"Nom\" required=\"required\" value=\"".$row['Nom_Produit']."\" /></td>
		<td align=right>Numero CAS* : &nbsp
		<input type=\"text\" name=\"NCas\" placeholder=\"64-19-7\" required=\"required\" value=\"".$row['Num_Cas']."\" /></td>
		<td align=right>Formule Chimique* : &nbsp
		<input type=\"text\" name=\"Formule\"  required=\"required\" value=\"".$row['Form_Chimique']."\" /></td></tr>
		";

$mess = $mess."<tr><td align=right>
		Etat du produit* : &nbsp
		<select name=\"Etat\">";
		
		$req = $bdd->prepare('SELECT * FROM etat');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row2) {
			$id = $row2['Id_etat'];
			$intitule = $row2['Nom_Etat'];
			
			if ($row['Id_etat'] == $id) {
				$mess = $mess."<option value=\"".$id."\" selected=\"selected\" >".$intitule."</option><br/>";
			}
			else {
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			}
		}
		
		$mess = $mess."</select></td>";
		$mess = $mess." <td align=right>Purete du produit : &nbsp
		<input type=\"text\" name=\"Purete\" value=\"".$row['Purete']."\" /></td>
		<td align=right>Risques : &nbsp
		<input type=\"text\" name=\"Risques\" placeholder=\"23-56\" value=\"".$row['Phrases_risques']."\" /></td></tr>";
		
		
		$mess = $mess." <td align=right>Conseils de prudence :&nbsp
		<input type=\text\" name=\"Conseils\" placeholder=\"23-32\" value=\"".$row['Phrases_conseil']."\" /></td>
		
		
		
		<td align=center>Symboles de danger<br/>
		Modifier les symboles? <strong>Oui</strong><input type =\"checkbox\" name=\"Modification\" id=\"Modification\" /><br/>
		<select name=\"Type_Danger\" >
			<option value = \"Attention\">Attention</option>
			<option value = \"Danger\"   >Danger</option>
		</select><br/>
		
		<p class=\"cadrechoix\">
 <input type=\"checkbox\" name=\"SGH01\" id=\"SGH01\" />
	<a href=\"Pictos/explos.jpg\" onclick=\"window.open('Pictos/explos.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 01</a>			
			
			
			<br/>
			<input type=\"checkbox\" name=\"SGH02\" id=\"SGH02\" />
				<a href=\"Pictos/flamme.jpg\" onclick=\"window.open('Pictos/flamme.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 02</a>			
						
		
			<br/>
			<input type=\"checkbox\" name=\"SGH03\" id=\"SGH03\" /> 
				
				<a href=\"Pictos/rondflam.jpg\" onclick=\"window.open('Pictos/rondflam.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 03</a>	<br/>		
			
			
		
			
			<input type=\"checkbox\" name=\"SGH04\" id=\"SGH04\" />
				<a href=\"Pictos/bottle.jpg\" onclick=\"window.open('Pictos/bottle.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 04</a>	<br/>	
			
			
			<input type=\"checkbox\" name=\"SGH05\" id=\"SGH05\" /> 
				<a href=\"Pictos/acid.jpg\" onclick=\"window.open('Pictos/acid.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 05</a>		<br/>	
			

		
			<input type=\"checkbox\" name=\"SGH06\" id=\"SGH06\" /> 
				<a href=\"Pictos/skull.jpg\" onclick=\"window.open('Pictos/skull.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 06</a><br/>			
			

								
			<input type=\"checkbox\" name=\"SGH07\" id=\"SGH07\" />
				<a href=\"Pictos/exclam.jpg\" onclick=\"window.open('Pictos/exclam.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 07</a>	<br/>		
			

	
			<input type=\"checkbox\" name=\"SGH08\" id=\"SGH08\" />
				<a href=\"Pictos/silhouet.jpg\" onclick=\"window.open('Pictos/silhouet.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 08</a>	<br/>		
			

			<input type=\"checkbox\" name=\"SGH09\" id=\"SGH09\" />
			<a href=\"Pictos/pollut.jpg\" onclick=\"window.open('Pictos/pollut.jpg','photo', 'height=20, width=40, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 09</a>	 <br/>		
			

			
		</p>
		
		</td>";
		$mess = $mess."
		<td align=center>Categorie CMR : &nbsp <br/>";
		
		$mess =	$mess."C :<input type=\text\" name =\"C\" size = \"5\" value=\"".$row['C']."\" /> &nbsp &nbsp 
		M : <input type=\"text\" name=\"M\" size = \"5\" value=\"".$row['M']."\" /> 
		&nbsp &nbsp <br/>R : <input type=\"text\" name=\"R\" size = \"5\" value=\"".$row['R']."\" /><br/>";
		
		
		$mess = $mess."</select></td></tr>
		<tr><td align=right>Lieu de stockage*:&nbsp <select name=\"Lieu\"><option value=0>Aucun</option><br/>";
		
		
		$req = $bdd->prepare('SELECT * FROM lieu order by Nom_lieu');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		
		foreach ($req as $row2) {
			$id = $row2['Id_lieu'];
			$intitule = $row2['Nom_lieu'];
			if ($row['Id_lieu'] == $id) {
				$mess = $mess."<option value=\"".$id."\" selected=\"selected\" >".$intitule."</option><br/>";
			} else {
				$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			}
		}

$mess = $mess."</select><br/>Etagère : <select name=\"sous_lieu\">";
$req_sl = $bdd->prepare('SELECT * FROM Etagere ORDER BY Nom_Etagere');
$req_sl -> execute();
foreach ($req_sl as $row0) {
	if ($row0['Etagere'] == $row['Etagere']) {
		$mess = $mess."<option value=\"".$row0['Etagere']."\" selected=\"selected\" >".$row0['Nom_Etagere']."</option>";
	} else {
			$mess = $mess."<option value=\"".$row0['Etagere']."\"  >".$row0['Nom_Etagere']."</option>";
	}
}


		$mess = $mess."</select></td>";
$mess = $mess."<td align=\"right\" >Propriétaire <small>si exclusif </small> 
<input type=\"text\" name=\"Proprietaire\" value=\"".$row['ID']."\" /></td>";






		$mess = $mess."<td align=right> Quantite (ml OU g): &nbsp
		<input type=\"text\" name =\"Quantite\" value = \"".$row['Quantite']."\" /></td></tr>
		<tr><td>Coordonnées <br/><textarea name =\"Fournisseur\" row=\"5\" columns = \"50\" placeholder=\"Tapez ici les coordonnées du fournisseur\">".$row['Fournisseur']."</textarea>
		
		</td><td>Commentaire : <textarea name = \"Observation\" row=3 columns = 30>".$row['Observations']."</textarea></td><td></td></tr>";
		
		
$mess = $mess."</table><input type=\"submit\" value=\"Modifier\"><br/><oblig>* : Champs obligatoire</oblig>
</form>";


}}
include "Base.php";








?>
