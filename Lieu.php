
<?php date_default_timezone_set("Europe/Paris");
	session_start();
	// Ce module permet de créer une page qui permet à l'utilisateur de géréer les utilisations/risques/Etat

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}


	
	
	
	
if (isset($_POST['Intitule_ajout'])) {
	$inti = $_POST['Intitule_ajout'];
	$inti = ucfirst(strtolower($inti));
	
	
	
	
	$existe = $bdd -> prepare('SELECT * FROM lieu WHERE Nom_lieu = ?');
	$existe-> execute(array($inti));
	$existe = $existe->fetchColumn();
	if ($existe == 0 ) {

	
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select Id_lieu FROM lieu order by Id_lieu');
		$req-> execute(Array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['Id_lieu'];
				if ($id == $nb) {
					$nb= $nb + 1;
				}
				else {
					$trouve = 1;
				}
			}
		}		
		return $nb;
	}
	
	$id = new_ID($bdd);
	
	try {
		$req = $bdd->prepare('INSERT INTO lieu(Id_lieu,Nom_lieu) VALUES (:nb,:inti)');
		$req->execute(array(
				'nb' => $id,
				'inti' => $inti,
				));
				echo '<script>alert("Insertion réussie");window.location.replace("Lieu.php");</script>';
	}catch (Exception $e) {
		echo '<script>alert("Erreur dans l\'insertion");history.back();</script>';
	}


} else {
	echo '<script>alert("Ce lieu existe déjà");history.back();</script>';

}

}
	// MODIFICATION

 else {
	if (isset($_POST['choix_util'])) {
		if ((isset($_POST['Intitule']))AND(!($_POST['choix_util'] == 0))) {

	if ($_POST['Intitule'] == "") {
	echo '<script>alert("Vous n\'avez pas rempli le champ");history.back();</script>';

	} else{
	$inti = $_POST['Intitule'];
	$inti = ucfirst(strtolower($inti));

	$id = $_POST['choix_util'];
	$inti = $_POST['Intitule'];
	
	try {
		$req = $bdd->prepare('UPDATE lieu SET Nom_lieu = ? WHERE Id_lieu =?');
		$req -> execute(array($inti,$id));
		echo '<script>alert("Modification effectuée");window.location.replace("Lieu.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}
}
}}
else {

			// SUPPRESSION

			if (isset($_POST['choix_lieu2'])) {
				if ($_POST['choix_lieu2'] == 0) {
					echo '<script>alert("Vous ne pouvez pas supprimer ceci");history.back();</script>';
				} else {
		$id = $_POST['choix_lieu2'];

	
	try {
		$req = $bdd->prepare('DELETE FROM produits WHERE Id_lieu = ?');
		$req -> execute(array($id));
		$req = $bdd->prepare('DELETE FROM lieu WHERE Id_lieu = ?');
		$req -> execute(array($id));
		echo '<script>alert("Suppression effectuée");window.location.replace("Lieu.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}

	}
	
	}else {
	
	// AFFICHAGE
	
	$mess = "<center><table cellspacing=40><tr><td><h2><center>Gestion des lieux</center></h2></center>";

$mess = $mess."<center><p><strong>Voulez-vous ajouter un choix de lieu?</strong> </p>
		<form method=\"post\" action=\"Lieu.php\">
			<input type=\"text\" name=\"Intitule_ajout\" style='text-transform:capitalize' />
			<input type=\"submit\" value=\"Ajouter\" />
		</form><br/>
		<p><strong>Voulez-vous modifier un choix de lieu?</strong></p>
		<form method=\"post\" action=\"Lieu.php\">
		<p>
		<select name=\"choix_util\">";
		

$req = $bdd->prepare('SELECT * FROM lieu order by Nom_lieu');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['Id_lieu'];
			$intitule = $row['Nom_lieu'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
		
		$mess = $mess."</select>
		<input type=\"text\" name=\"Intitule\" style='text-transform:capitalize' />
		<input type=\"submit\" value=\"Modifier\" />
		</form><br/> </p>
		
		<p><strong>Voulez-vous supprimer un choix de lieu?</strong></p>
		<form method=\"post\" action= \"Lieu.php\">
		<p>
		<select name=\"choix_lieu2\">";
		
		$req = $bdd->prepare('SELECT * FROM lieu order by Nom_lieu');
		$req -> execute();
		$id = "";
		$intitule = "";
		foreach ($req as $row) {
			$id = $row['Id_lieu'];
			$intitule = $row['Nom_lieu'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
		}
		
		$mess = $mess."</select>
		<input type=\"submit\" value=\"Supprimer\" />
		</form><br/></p></td>";
		


		
	include "Base.php";


		}
	}
}

	
?>