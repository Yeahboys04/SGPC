<?php date_default_timezone_set("Europe/Paris");
session_start();
$_SESSION['Modif'] = 0;
//Fiche Personnelle
if (!($_SESSION['id']== null)) {

	// Si on tente d'aller sur la fiche d'un autre membre sans être admin, on est renvoyé en arrière avec une alerte. 
	if (isset($_GET['id'])) {
		if (!($_GET['id'] == $_SESSION['id'])) {
			if (!($_SESSION['Admin'] == 1)) {
				echo '<script>alert(\"Restez sur VOTRE fiche\");window.location.replace(\"Fiche_Perso.php?id='.$_SESSION['id'].'\")</script>';
			}
		}
		
	
			// Connexion à la base de données.

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	include "Fonction_utilisateurs.php";

	$mess ="";
	$nb = $bdd->prepare('SELECT count(*) FROM utilisateurs WHERE id = ?');
	$nb->execute(array($_GET['id']));
	$count = $nb->fetchColumn();
	
	// On regarde si l'id de l'adresse url correspond à une ID valide. Si NON, on renvoie sur la page perso de l'utilisateur en cours.
	if ($count == 0) {
		if ($_GET['id'] == 0 ) {
			echo '<script>alert("Connectez-vous!");window.location.replace("Accueil.php");</script>';
		} else {
		echo '<script>alert("Cet identifiant n\'existe pas.");window.location.replace("Fiche_Perso.php?id='.$_SESSION['id'].'");</script>';
		}
		
	}else{
		//Sinon, on affiche son nom et son prénom , et administrateur si besoin
		
		$nb = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$nb->execute(array($_GET['id']));
		$nom = "";
		$prenom = "";
		$admin = 0;
		foreach ($nb as $row ) {
			$nom = $row['NOM'];
			$prenom = $row['Prenom'];
			$habilitation = "";
			if ($row['Habilitation'] == 'ADMIN' ) {
				$admin = 1;
				$habilitation = "<br/>Administrateur";
			}
		}
		$mess = "<br/><center><strong>".$nom."</strong> ".$prenom."  <br/><strong>".$habilitation."</strong></br>";
		
		$mess = $mess.moduleFiche($_GET['id'],$bdd);
		
		$modif_mdp = moduleModifMdp($_GET['id']);
		$passage_admin = modulePassageAdmin($_GET['id'],$bdd);
		
		$suppr = moduleSuppression($_GET['id'],$bdd);
		
		if (!($_SESSION['Admin'] == 0)) {
			if (($_SESSION['id'] == 1 )AND (!($_GET['id'] == 1))) {
			$mess = $mess.$suppr."<br/><br/>";
		}
			$mess = $mess.$passage_admin."<hr>";
		}
		if (!($_SESSION['Admin'] == 2)) {
		
		$retrait = "<center><strong>Derniers retraits</strong><br/><br/>";
		$retrait = $retrait.histo_perso_retrait($_GET['id'],$bdd);
		$retrait = $retrait."</center>";
		$mess = $mess.$modif_mdp."<br/><hr><br/>".$retrait."<br/><br/>";
		} else {
			$mess = $mess.$modif_mdp."<br/><br/>";
		}
	}

	include "Base.php";
		}else {
			// Si l'adressse URL est modifiée/incompléte, on renvoie la personne sur sa page personnelle.
			echo '<script>window.location.replace("Fiche_Perso.php?id='.$_SESSION['id'].'");</script>';
	}
}else {
	echo '<script>alert("Veuillez vous connecter");window.location.replace("Accueil.php");</script>';
}
?>