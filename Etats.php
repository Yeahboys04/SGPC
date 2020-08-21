
<?php date_default_timezone_set("Europe/Paris");
	session_start();
	// Ce module permet de créer une page qui permet à l'utilisateur de géréer les etats

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
$existe = $bdd -> prepare('SELECT * FROM etat WHERE Nom_Etat = ?');
	$existe-> execute(array($inti));
	$existe = $existe->fetchColumn();
	if ($existe == 0 ) {

	
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select Id_etat FROM etat order by Id_etat');
		$req-> execute(Array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['Id_etat'];
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
		$req = $bdd->prepare('INSERT INTO etat(Id_etat,Nom_Etat) VALUES (:nb,:inti)');
		$req->execute(array(
				'nb' => $id,
				'inti' => $inti,
				));
				echo '<script>alert("Insertion réussie");window.location.replace("Etats.php");</script>';
	}catch (Exception $e) {
		echo '<script>alert("Erreur dans l\'insertion");history.back();</script>';
	}


} else {
	echo '<script>alert("Cet etat existe déjà");history.back();</script>';

}
}
	// MODIFICATION

 else {
	if (isset($_POST['choix_util'])) {
		if ((isset($_POST['Intitule']))AND(!($_POST['choix_util'] == 0))) {

	$inti = $_POST['Intitule'];
	$inti = ucfirst(strtolower($inti));
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	$id = $_POST['choix_util'];
	$inti = $_POST['Intitule'];
	
	try {
		$req = $bdd->prepare('UPDATE etat SET Nom_Etat = ? WHERE Id_Etat =?');
		$req -> execute(array($inti,$id));
		echo '<script>alert("Modification effectuée");window.location.replace("Etats.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}
	
	
	} else {
		echo '<script>alert("Champs de modifications incomplets");history.back();</script>';
	}
}else {

			// SUPPRESSION

			if (isset($_POST['choix_util2'])) {
				if ($_POST['choix_util2'] == 0) {
					echo '<script>alert("Vous n\'avez pas sélectionné d\'état à supprimer");history.back();</script>';
				} else {
	$id = $_POST['choix_util2'];

	
	try {
		$req = $bdd->prepare('DELETE FROM etat WHERE Id_Etat = ?');
		$req -> execute(array($id));
		echo '<script>alert("Suppression effectuée");window.location.replace("Etats.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}
	}
	}else {
		
	
$mess = "<center><table cellspacing=40><tr><td><h2><center>Gestion des états</center></h2></center>";

$mess = $mess."<center><p><strong>Voulez-vous ajouter un choix d'état?</strong> </p>
		<form method=\"post\" action=\"Etats.php\">
			<input type=\"text\" name=\"Intitule_ajout\" style='text-transform:capitalize' />
			<input type=\"submit\" value=\"Ajouter\" />
		</form><br/>
		<p><strong>Voulez-vous modifier un choix d'état?</strong></p>
		<form method=\"post\" action=\"Etats.php\">
		<p>
		<select name=\"choix_util\">
		<option value= 0 > Aucun </option><br/>";
	

		$req = $bdd->prepare('SELECT * FROM etat order by Nom_Etat');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['Id_etat'];
			$intitule = $row['Nom_Etat'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
		
		$mess = $mess."</select>
		<input type=\"text\" name=\"Intitule\" style='text-transform:capitalize' />
		<input type=\"submit\" value=\"Modifier\" />
		</form><br/> </p>
		
		<p><strong>Voulez-vous supprimer un choix d'état?</strong></p>
		<form method=\"post\" action= \"Etats.php\">
		<p>
		<select name=\"choix_util2\">
		<option value= 0 > Aucun </option><br/>";
		
	// Menu déroulant pour la suppression
		$req = $bdd->prepare('SELECT * FROM etat');
		$req -> execute();
		$id = "";
		$intitule = "";
		foreach ($req as $row) {
			$id = $row['Id_etat'];
			$intitule = $row['Nom_Etat'];
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