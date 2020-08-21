<?php
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
if (!(isset($_POST['choix']))) {

$mess = "<center><h2>Stocks des produits</h2>
<br/>
<br/><form action=\"Stocks.php\" method=\"post\">
Choix du produit à consulter : <select name=\"choix\"><option value=0></option>";

$req = $bdd->prepare('SELECT DISTINCT(Nom_Produit) FROM produits ORDER BY Nom_Produit');
$req -> execute();
foreach ($req as $row) {
	$mess = $mess."<option value=\"".$row['Nom_Produit']."\">".$row['Nom_Produit']."</option><br/>";
}
$mess = $mess."</select> <br/><input type=\"submit\" value=\"Valider\" /><br/><br/>";


}else {

$mess = "<center><h2>Stocks de : ".$_POST['choix']."</h2></br><br/>
<table width = 100% border = 1>
<th>Nom du produit <br/>Numéro Cas </th>
<th>Lieu de stockage</th>
<th>Pureté</th>
<th>Propriétaire </th>
<th>Quantité </th>
<th>Retrait</th>";

$req = $bdd->prepare('SELECT * FROM produits WHERE Nom_Produit = ? ORDER BY Id_lieu');
$req -> execute(array($_POST['choix']));
foreach ($req as $row) {
	$mess = $mess."<tr>
	<td align=\"center\">".$row['Nom_Produit']."<br/>".$row['Num_Cas']."</td>
	<td align=\"center\">";
	$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
	$req2 -> execute(array($row['Id_lieu']));
	foreach ($req2 as $row2) {
		$mess = $mess.$row2['Nom_lieu']."</td>";
	}
	$mess = $mess."<td align=\"center\">".$row['Purete']."</td>
	<td align=\"center\">".$row['ID']."</td>
	<td align=\"center\">".$row['Quantite']."</td>
	<td align=\"center\"><form action=\"Retrait.php?id=".$row['Id_Produit']."\" method=\"post\"><input type=\"submit\" value=\"Retrait\" /></form>
	</td>
	</tr>";
}

$mess = $mess."</table><br/><br/>";
}



include "Base.php";

?>