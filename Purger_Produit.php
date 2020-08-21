<?php date_default_timezone_set("Europe/Paris");
session_start();
	
	
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques','root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	
	
if (!(isset($_GET['id']))) {
	
	if (!isset($_POST['lieu'])) {
	
	// Si aucun produit n'est spécifié, on retourne a la page précédente
	echo '<script>window.location.replace("Purge_Produit.php");</script>';
	} else {
		// Si on fait une purge par lieu : 
		
			$req = $bdd->prepare('SELECT * FROM produits WHERE Id_lieu = ?');
			$req -> execute(array($_POST['lieu']));
			foreach ($req as $row) {
				$req2 = $bdd->prepare('DELETE FROM retrait WHERE Id_Produit = ?');
				$req2 -> execute(array($row['Id_Produit']));
			}
			$req = $bdd->prepare('DELETE FROM produits WHERE Id_lieu = ?');
			$req -> execute(array($_POST['lieu']));
			$req = $bdd->prepare('DELETE FROM lieu WHERE Id_lieu = ?');
			$req -> execute(array($_POST['lieu']));
			echo '<script>alert("Suppression du lieu et des produits effectuée");window.location.replace("Purge_Produit.php");</script>';
		
		
		
} 
}
	else {
		
		

	
	try {
	// On supprime les retraits concernant ce produit
	
	$req = $bdd->prepare('DELETE FROM Retrait WHERE Id_Produit = ?');
	$req -> execute(array($_GET['id']));
	
	// On supprime le produits
	$req = $bdd->prepare('DELETE FROM Produits WHERE Id_Produit = ?');
	$req -> execute(array($_GET['id']));
		echo '<script>alert("Produit et retraits correspondants supprimés");window.location.replace("Purge_Produit.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("FAIL");';
}
}
	
?>
