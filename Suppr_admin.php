<?php date_default_timezone_set("Europe/Paris");

if ($_POST['suppr'] == 'non') {
// On vérifie la confirmation de la suppression
	echo '<script>alert("Vous n\'avez pas validé!");history.back();</script>';
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
	try {
	
	$id = $_POST['choix_pers'];
	$req = $bdd->prepare ('DELETE FROM utilisateurs WHERE id = ?');
	$req -> execute(array($id));
	echo '<script>alert("Suppression de la personne effectuée.");window.location.replace("Fiche_perso.php");</script>';
	
	} catch (Exception $e) {
		echo '<script>alert("Erreur dans la suppression."); history.back();</script>';
	}
}

?>