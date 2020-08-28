<?php date_default_timezone_set("Europe/Paris");

session_start();





if ($_SESSION['Admin'] == 0 ) {
	if (!($_GET['id'] == $_SESSION['id'])) {
	// Si la personne n'est pas admin, et qu'elle essaie de changer le mot de passe d'une autre personne, erreur.
	echo '<script>alert("Vous ne pouvez modifier que votre propre mot de passe");window.location.replace("Fiche_Perso.php");</script>';
	}
}


		try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	
	$mot_passe1 = $_POST['Mdp'];
	$mot_passe2 = $_POST['Mdp2'];
	$id = $_GET['id'];
	if (!($mot_passe1 == $mot_passe2)) {
		echo '<script>alert("Vous n\'avez pas tapé deux fois le même mot de passe");history.back();</script>';
	}
	else {
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$req -> execute(array($id));
		$nom = "";
		foreach ($req as $row){
			$nom = $row['NOM'];
		}
		$hach = strtoupper($nom).".".strtolower($mot_passe1);
		
		$hach = MD5($hach);
		
		$req = $bdd->prepare('UPDATE utilisateurs SET hach = ? WHERE id = ?');
		$req->execute(array($hach,$id));
		echo '<script>alert("Changements effectués"); window.location.replace("Fiche_Perso.php?id='.$_GET['id'].'");</script>';
	}



	


















?>