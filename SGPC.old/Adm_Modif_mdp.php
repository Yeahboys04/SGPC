<?php date_default_timezone_set("Europe/Paris");


$id = $_POST['choix'];

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
	// On v�rifie que les deux mots de passes entr�s sont les m�mes.
	
	if (!($mot_passe1 == $mot_passe2)) {
		echo '<script>alert("Vous n\'avez pas tap� deux fois le m�me mot de passe");history.back();</script>';
	}
	else {
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$req -> execute(array($id));
		$nom = "";
		foreach ($req as $row){
			$nom = $row['NOM'];
		}
		
		// On concat�ne le nom, un point, puis le nouveau mot de passe avant de le convertir avec la fonction MD5
		$hach = strtoupper($nom).".".strtolower($mot_passe1);
		
		$hach = MD5($hach);
		// On le modifie dans la base
		$req = $bdd->prepare('UPDATE utilisateurs SET hach = ? WHERE id = ?');
		$req->execute(array($hach,$id));
		echo '<script>alert("Changements effectu�s"); window.location.replace("Fiche_Perso.php");</script>';
	}









?>