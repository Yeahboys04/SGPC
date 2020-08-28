<?php date_default_timezone_set("Europe/Paris");
session_start();
// Cette partie servira à gérer le module permettant d'entrer un nouveau produit dans la base de données.


	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	
	}



$mess =  " <center><strong> Entrée d'un nouveau produit. </strong></center><br/>";

$mess =  $mess."<center><table cellspacing=50 >";

$mess = $mess."<form action=\"Produits/Ajout_Produit.php?id=".$_SESSION['id']."\" method=\"post\"><tr><td align=right>
		Nom du produit* : &nbsp
		<input type=\"text\" name=\"Nom\" required=\"required\" /></td>
		<td align=right>Numero CAS* : &nbsp
		<input type=\"text\" name=\"NCas\" placeholder=\"64-19-7\" required=\"required\" /></td>
		<td align=right>Formule Chimique* : &nbsp
		<input type=\"text\" name=\"Formule\"  required=\"required\" /></td></tr>
		";

$mess = $mess."<tr><td align=right>
		Etat du produit* : &nbsp
		<select name=\"Etat\">";
		
		$req = $bdd->prepare('SELECT * FROM etat');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['Id_etat'];
			$intitule = $row['Nom_Etat'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
		
		$mess = $mess."</select></td>";
		$mess = $mess." <td align=right>Purete du produit : &nbsp
		<input type=\"text\" name=\"Purete\" /></td>
		<td align=right>Risques : &nbsp
		<input type=\"text\" name=\"Risques\" placeholder=\"23-56\" /></td></tr>";
		
		
		$mess = $mess." <td align=right>Conseils de prudence :&nbsp
		<input type=\text\" name=\"Conseils\" placeholder=\"23-32\"/></td>
		
		
		
		<td align=center>Symboles de danger
			
		<select name=\"Type_Danger\" >
			<option value = \"Attention\">Attention</option>
			<option value = \"Danger\"   >Danger</option>
		</select><br/>
		
		<p class=\"cadrechoix\">
 <input type=\"checkbox\" name=\"SGH01\" id=\"SGH01\" />
	<a href=\"Pictos/explos.jpg\" onclick=\"window.open('Pictos/explos.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 01</a>			
			
			
			<br/>
			<input type=\"checkbox\" name=\"SGH02\" id=\"SGH02\" />
				<a href=\"Pictos/flamme.jpg\" onclick=\"window.open('Pictos/flamme.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 02</a>			
						
		
			<br/>
			<input type=\"checkbox\" name=\"SGH03\" id=\"SGH03\" /> 
				
				<a href=\"Pictos/rondflam.jpg\" onclick=\"window.open('Pictos/rondflam.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 03</a>	<br/>		
			
			
		
			
			<input type=\"checkbox\" name=\"SGH04\" id=\"SGH04\" />
				<a href=\"Pictos/bottle.jpg\" onclick=\"window.open('Pictos/bottle.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 04</a>	<br/>	
			
			
			<input type=\"checkbox\" name=\"SGH05\" id=\"SGH05\" /> 
				<a href=\"Pictos/acid.jpg\" onclick=\"window.open('Pictos/acid.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 05</a>		<br/>	
			

		
			<input type=\"checkbox\" name=\"SGH06\" id=\"SGH06\" /> 
				<a href=\"Pictos/skull.jpg\" onclick=\"window.open('Pictos/skull.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 06</a><br/>			
			

								
			<input type=\"checkbox\" name=\"SGH07\" id=\"SGH07\" />
				<a href=\"Pictos/exclam.jpg\" onclick=\"window.open('Pictos/exclam.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 07</a>	<br/>		
			

	
			<input type=\"checkbox\" name=\"SGH08\" id=\"SGH08\" />
				<a href=\"Pictos/silhouet.jpg\" onclick=\"window.open('Pictos/silhouet.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 08</a>	<br/>		
			

			<input type=\"checkbox\" name=\"SGH09\" id=\"SGH09\" />
			<a href=\"Pictos/pollut.jpg\" onclick=\"window.open('Pictos/pollut.jpg','photo', 'height=100, width=200, top=100, left=100, toolbar=no, menubar=yes, location=no, resizable=yes, scrollbars=no, status=no'); return false;\">SGH 09</a>	 <br/>		
			

			
		</p>
		
		</td>";
		$mess = $mess."
		<td align=center>Categorie CMR : &nbsp <br/>";
		
		$mess =	$mess."C :<input type=\text\" name =\"C\" size = \"5\" /> &nbsp &nbsp M : <input type=\"text\" name=\"M\" size = \"5\" /> 
		&nbsp &nbsp <br/>R : <input type=\"text\" name=\"R\" size = \"5\" /><br/>";
		
		
		$mess = $mess."</select></td></tr>
		<tr><td align=right>Lieu de stockage*:&nbsp <select name=\"Lieu\"><option value=0>Aucun</option><br/>";
		
		
		$req = $bdd->prepare('SELECT * FROM lieu order by Nom_lieu');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		
		foreach ($req as $row) {
			$id = $row['Id_lieu'];
			$intitule = $row['Nom_lieu'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
$mess = $mess."</select><br/>
Etagère : <select name=\"Sous_lieu\"><option value=null></option>";
$req = $bdd->prepare('SELECT * FROM etagere ORDER BY Nom_Etagere');
$req -> execute();
foreach ($req as $row) {
	$mess = $mess."<option value=\"".$row['Etagere']."\">".$row['Nom_Etagere']."</option>";
}



		$mess = $mess."</select></td><td align=right> Proprietaire <small>(Si exclusif)</small>
<input type=\"text\" name=\"Proprietaire\" />
</td><td align=right> Quantite (ml OU g): &nbsp
		<input type=\"text\" name =\"Quantite\" value = 0 /></td></tr>
		<tr><td>Coordonnées <br/><textarea name =\"Fournisseur\" row=\"5\" columns = \"50\" placeholder=\"Tapez ici les coordonnées du fournisseur\"></textarea>
		
		</td><td>Commentaire : <textarea name = \"Observation\" row=3 columns = 30></textarea></td><td></td></tr>";
		
		
$mess = $mess."</table><input type=\"submit\" value=\"Ajouter\"><br/><oblig>* : Champs obligatoire</oblig>
</form>";
include "Base.php";








?>