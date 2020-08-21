<?php date_default_timezone_set("Europe/Paris");


/* 
**
**		Ce fichier php sert à afficher la partie supérieure fixe de l'écran, qui gère le retour à l'accueil, et la déconnexion.
**
*/




					// Connexion à la base de données
try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root', 'root', $pdo_options);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}

$id_actuelle = $_SESSION['id'];

$actuel = $bdd->prepare('SELECT nom, prenom FROM utilisateurs WHERE id = ?');
$actuel -> execute((array($id_actuelle)));

$nom = "";
$prenom = "";


	foreach ($actuel as $row) {
		$nom = $row['nom'];
		$prenom = $row['prenom'];
	}
	echo '<a href = "Fiche_Perso.php">Page Personnelle </a>Vous etes connecte en tant que '.$prenom.' '.$nom.'.(<a href="Deconnexion.php">Deconnexion</a>)';





?>