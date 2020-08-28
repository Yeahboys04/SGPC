<?php date_default_timezone_set("Europe/Paris"); 

// On verifie si l'utilisateur a bien confirmé son choix
if ($_POST['suppr'] == 'non') {

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
	
	
	
	$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
	$req -> execute((array($_GET['id'])));
	$superadmin = 0;
	foreach ($req as $row) {
		if ($row['NOM'] == 'ADMIN') {
			if ($row['Prenom'] == 'Admin') {
				$superadmin = 1;
			}
		}
	}
	// On vérifie que ce n'est pas le super-admin qu'on demande a supprimer
	
	if (!($superadmin == 0)) {
		echo '<script>alert("Ce compte n\'est pas supprimable!");window.location.replace("Fiche_perso.php");</script>';
	}else {
	
	$req = $bdd->prepare('DELETE FROM utilisateurs WHERE id = ?');
	$req -> execute((array($_GET['id'])));
	echo '<script>alert("Suppression effectué");window.location.replace("Fiche_perso.php");</script>';
	}
}






?>