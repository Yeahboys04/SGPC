<?php date_default_timezone_set("Europe/Paris");

session_start();
if ($_SESSION['Admin'] < 1 ) {
	//Seul un administrateur peut voir cette partie, donc on vérifié
	echo '<script>alert("Accès non autorisé");history.back();</script>';
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
	
	$mess = "";
	if (!(isset($_POST['nb_annee']))) {
		$mess = $mess."<center><br/><h2>Purge des produits</h2>
		<form action=\"Purge_Produit.php\" method=\"post\">
		Veuillez choisir le nombre d'années pour l'affichage des produits. &nbsp&nbsp&nbsp
		<select name=\"nb_annee\"><option 
			<option value=\"1\">1</option>
			<option value=\"2\">2</option>
			<option value=\"3\">3</option>
			<option value=\"4\">4</option>
		</select><input type=\"submit\" value=\"Choix\" />
		</form><br/>";
		$mess = $mess."<br/><br/><hr><br/>Purge par lieu<br/><br/>
<h3> /!\Attention, suppression définitive du lieu, des produits qui s'y trouvent et des retraits correspondants!!! </h3><br/>
	<form action=\"Purger_Produit.php\" method=\"post\">
		Veuillez choisir le lieu pour la purge des produits &nbsp&nbsp&nbsp<select name=\"lieu\">
	";
	$req =$bdd->prepare('SELECT * FROM lieu ORDER By Nom_lieu');
	$req -> execute();

foreach ($req as $row) {
	$req2 = $bdd->prepare('SELECT COUNT(*) AS nb FROM produits WHERE Id_lieu = ?');
	$req2->execute(array($row['Id_lieu']));
	$nb = "";
	foreach($req2 as $row2) {
		$nb = $row2['nb'];
	}
	
	$mess = $mess."<option value=\"".$row['Id_lieu']."\">".$row['Nom_lieu']." contenant ".$nb." produits</option>";
}
	$mess = $mess."</select><input type=\"submit\" value=\"Purger\" />
</form></center><br/><br/>";


	} else {
	
	$nbannee = $_POST['nb_annee'];
	
	
	
	
	
	$mess = "<h2><center>Produits non-utilisés depuis ".$nbannee." ans </center></h2> <br/><br/>
	
	<table border = 1 width = 100%><th>Nom du produit<br/>Numéro CAS</th><th>Purete</th><th>Propriétaire<br/>Lieu de stockage</th><th>Quantité restante</th>";

	$req = $bdd->prepare('SELECT * FROM produits ORDER BY Nom_Produit');
	$req -> execute();
	
	foreach ($req as $row) {
		$id_p = $row['Id_Produit'];
		
		
		
		
		$req2 = $bdd->prepare('SELECT * FROM Retrait WHERE Id_Produit = ? AND Quantite > 0 ORDER BY Date_Retrait DESC');
		
		$req2 -> execute(array($id_p));
		
		//$date = date(DATE_ATOM);
		$jour = date("d");
		$mois = date("m");
		$annee = date("Y");
		
		$annee = $annee-$nbannee;
		$ancienne_date = $annee."-".$mois."-".$jour;
		$compteur = 1;
		foreach ($req2 as $row2) {
		if ($compteur == 1) {
		
		if ($ancienne_date > $row2['Date_Retrait'] ) {
			$compteur = $compteur +1;
			$mess = $mess."<tr><td align=\"center\">".$row['Nom_Produit']."<br/>".$row['Num_Cas']."</td>
			<td align=\"center\">".$row['Purete']."</td>
			<td align=\"center\">";
			
			if ($row['ID'] == null ) {
				$mess = $mess."N/A <br/>";
			}else {
			
				$mess = $mess.$row['ID'];				}
		
		
		$req3 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
		$req3 -> execute(array($row['Id_lieu']));
		foreach ($req3 as $row3) {
			$mess = $mess.$row3['Nom_lieu']."</td><td align=\"center\">".$row['Quantite']."</td><td align=\"center\">";
		}
		
		$mess = $mess."</tr>";
		
		
			// Faire propriétaire/lieu de stockage quantité restante
}}
	else {
	echo '<script>alert("Aucun produit non utilisé.");history.back();</script>';
	}
}


}
	$mess = $mess."</table><br/>";
}

	include "Base.php";






}
?>
