<?php date_default_timezone_set("Europe/Paris");

session_start();

if ($_SESSION['Admin'] == 0 ) {
	echo '<script>alert("Vous n\'avez pas accès");history.back();</script>';
	
}
else {
	
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	
	}
	
	
	if (!(is_numeric($_POST['Quantite']))) {
		echo '<script>alert("Vous n\'avez pas entré un entier");history.back();</script>';
	} else {
	$id = $_POST['ID_Produit'];
	$quantite = 0;
	
	$req = $bdd -> prepare('SELECT * FROM produits WHERE Id_Produit = ?');
	$req -> execute(array($id));
	foreach($req as $row) {
		$quantite = $row['Quantite'];
	}
	
	$quantite = $quantite + $_POST['Quantite'];
	try {
	$req = $bdd->prepare('UPDATE Produits SET Quantite = ? WHERE Id_Produit = ? ');
	$req -> execute(array($quantite,$id));
	
	echo '<script>alert("Ajout réussi");window.location.replace("../Adm_Depot_Produit.php");</script>';

	
	} catch (Exception $e) {
		echo '<script>alert("Erreur dans le depot");history.back();</script>';
	}
}
}


	
	


























?>