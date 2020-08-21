<?php date_default_timezone_set("Europe/Paris");
session_start();

// Partie pour réaliser l'inventaire total des produits

	if ($_SESSION['Admin'] < 1) {
		echo '<script>alert("Vous n\'avez pas le droit");history.back();</script>';
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
	
	
	
	$req = $bdd->prepare('SELECT * FROM Produits WHERE Quantite = 0 ORDER By Nom_Produit');
	$req -> execute();
	
	if (isset($_GET['tri'])) {
	if ($_GET['tri'] == "Lieu") {
		$req = $bdd->prepare('SELECT * FROM Produits WHERE Quantite = 0 ORDER By Id_lieu');
	$req -> execute();
	}
	
	if ($_GET['tri'] == "Proprietaire") {
			$req = $bdd->prepare('SELECT * FROM Produits WHERE Quantite = 0 ORDER By ID');
	$req -> execute();
	}
	if ($_GET['tri'] == "Quantite") {
		$req = $bdd->prepare('SELECT * FROM Produits WHERE Quantite = 0 ORDER By Quantite DESC');
		$req -> execute();
	}
	}
	
		$mess = "<center>
<input type=\"button\" value=\"Imprimer cette page\" onClick=\"window.print()\">
<input type=\"button\" value=\"Retour arrière\" onClick=window.location.replace(\"Retrait.php\")>
<br/></center>";
	
	$mess = $mess."<h2><center> Inventaire des produits vides </center></h2>
	<br/><br/>
	<table border = \"1\" width = 100%>";
	
	// On cre un tableau, qui va, pour chaque ligne dresser les caractéristiques de chaque produit
	
	$mess = $mess."<th><a href=\"inventaire0.php\">Nom du produit/Num Cas</a></th>
	<th>Purete</th>
	<th><a href=\"inventaire0.php?tri=Lieu\">Lieu de stockage</a></th>
	<th><a href=\"inventaire0.php?tri=Proprietaire\">Propriétaire</a></th>
	<th><a href=\"inventaire0.php?tri=Quantite\">Quantite</a></th>
	<th>Dernier retrait</th>";
	$compteur = 0;
	foreach ($req as $row) {
	$compteur = 0;
	$mess = $mess."<tr><td align=\"center\">".$row['Nom_Produit']."<br/>".$row['Num_Cas']."</td><td align=\"center\">";
	if ($row['Purete'] == "") {
		$mess = $mess."N/A";
	} else {
		$mess = $mess.$row['Purete'];
	}
	$mess = $mess."</td>
	<td align=\"center\">";
	
	$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
	$req2->execute(array($row['Id_lieu']));
	foreach ($req2 as $row2) {
		$mess = $mess.$row2['Nom_lieu'];
	}
	$mess = $mess."</td><td align=\"center\">";
	$nom = "N/A";
	if (!($row['ID'] == null)){
		$nom = $row['ID'];
	}
	$mess = $mess.$nom;
	
	$mess = $mess."</td><td align=\"center\">".$row['Quantite']."</td><td align=\"center\">";
	//Dans la dernière case, on y ajoute le dernier retrait.
	$req2 = $bdd->prepare('SELECT *,Count(*) as nb FROM retrait WHERE Id_Produit = ? ORDER BY Date_Retrait DESC limit 1');
	$req2 -> execute(array($row['Id_Produit']));

	


	foreach ($req2 as $row2) {
			if ($row2['nb'] == 0 ) {
					$mess = $mess."N/A </td></tr>";
			} else {
				$req3 = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ?');
				$req3 -> execute(array($row2['ID']));
				$nom = "";
				$prenom = "";
				foreach ($req3 as $row3) {
					$nom = $row3['NOM'];
					$prenom = $row3['Prenom'];
				}
				$mess = $mess.$row2['Date_Retrait']."<br/>".$nom." ".$prenom."</td></tr>";
				$compteur = $compteur + 1;
			
	}
	}
	}
	$mess = $mess."</table>";

	echo $mess;
}









?>
