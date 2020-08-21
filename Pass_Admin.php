<?php date_default_timezone_set("Europe/Paris");

$id = $_GET['id'];

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	
	$existe = $bdd->prepare('SELECT * from utilisateurs WHERE id = ?');
	$existe -> execute(array($id));
	$nb = $existe->fetchColumn();
	
	// On vérifie qu'il existe bien un utilisateur avec cet id, et on le passe ADMIN
	
	if ($nb == 0 ) {
		echo '<script>alert("Cet identifiant n\'existe pas");history.back();</script>';
	} else {
		$req = $bdd -> prepare('UPDATE utilisateurs SET habilitation = "ADMIN" Where id = ?');
		$req -> execute(array($id));
		echo '<script>alert("Cet utilisateur est désormais administrateur");history.back();</script>';
	}







?>