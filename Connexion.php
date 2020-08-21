<?php date_default_timezone_set("Europe/Paris");
session_start();
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root', 'root', $pdo_options);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}



	include "Fonction_connexion.php";
	
	// On r�cup�re les valeurs de Nom et mdp rentr�es sur la page d'acceuil.

	$nom = strtoupper($_POST['Nom']);
	$mdp = strtolower($_POST['mdp']);
	
	/* 
	* 
	* On concat�ne le nom et le mot de passe, s�par� par un point 
	* On le passe ensuite dans une fonction de hashage, qui donne le mot de passe g�n�r� automatiquement.
	*
	*/
	
	$mot_de_passe = $nom.'.'.$mdp;
	$hashage = MD5($mot_de_passe);
	
	$id = connexion($nom,$hashage,$bdd);
	
	if ($id == 0 ) {		
		echo '<script>alert("Mauvais identifiants.");
		window.location.replace("Accueil.php");</script>';
	}else{
		$_SESSION['id'] = $id;
		$_SESSION['Admin'] = isAdmin($id,$bdd);
		
		
		echo '<script>window.location.replace("Retrait.php");</script>';
	}
	


?>