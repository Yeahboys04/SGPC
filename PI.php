
<?php date_default_timezone_set("Europe/Paris");
	session_start();
	// Ce module permet de cr�er une page qui permet � l'utilisateur de g�r�er les protections individuelles

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
	
	
	$existe = $bdd -> prepare('SELECT * FROM protection_indi WHERE Nom_Pro = ?');
	$existe-> execute(array($inti));
	$existe = $existe->fetchColumn();
	if ($existe == 0 ) {

	
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 0;
		$req = $bdd->prepare('Select ID_ProIn FROM protection_indi order by ID_ProIn');
		$req-> execute(Array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['ID_ProIn'];
				if ($id == $nb) {
					$nb = $nb + 1;
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
		$req = $bdd->prepare('INSERT INTO protection_indi(ID_ProIn,Nom_Pro) VALUES (:nb,:inti)');
		$req->execute(array(
				'nb' => $id,
				'inti' => $inti,
				));
				echo '<script>alert("Insertion r�ussie");window.location.replace("PI.php");</script>';
	}catch (Exception $e) {
		
		echo '<script>alert("Erreur dans l\'insertion");history.back();</script>';
	}


} else {
	echo '<script>alert("Ce moyen de protection individuel existe d�j�");history.back();</script>';

}
}
	// MODIFICATION

 else {
	if (isset($_POST['choix_util'])) {
		if ((isset($_POST['Intitule']))AND(!($_POST['choix_util'] == 0))) {

	if ($_POST['Intitule'] == null) {
	echo '<script>alert("Vous n\'avez pas rempli le champ");history.back();/<script>';
} else{

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
		$req = $bdd->prepare('UPDATE protection_indi SET Nom_Pro = ? WHERE ID_ProIn =?');
		$req -> execute(array($inti,$id));
		echo '<script>alert("Modification effectu�e");window.location.replace("PI.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}
}
}}
else {

			// SUPPRESSION

			if (isset($_POST['choix_util2'])) {
				if ($_POST['choix_util2'] == 0) {
					echo '<script>alert("Vous ne pouvez pas supprimer ceci");history.back();</script>';
				} else {
	$id = $_POST['choix_util2'];
	if (!($id == 0)) {
	
	try {
		$req = $bdd->prepare('DELETE FROM protection_indi WHERE ID_ProIn = ?');
		$req -> execute(array($id));
		echo '<script>alert("Suppression effectu�e");window.location.replace("PI.php");</script>';
	} catch (Exception $e) {
		echo '<script>alert("Erreur");history.back();</script>';
	}
	}
	}
	}else {
	$mess = "<center><table cellspacing=40><tr><td><h2><center>Gestion des protections individuelles</center></h2></center>";

$mess = $mess."<center><p><strong>Voulez-vous ajouter un choix de protection individuelle?</strong> </p>
		<form method=\"post\" action=\"PI.php\">
			<input type=\"text\" name=\"Intitule_ajout\" style='text-transform:capitalize' />
			<input type=\"submit\" value=\"Ajouter\" />
		</form><br/>
		<p><strong>Voulez-vous modifier un choix de protection individuelle?</strong></p>
		<form method=\"post\" action=\"PI.php\">
		<p>
		<select name=\"choix_util\">";
		

		$req = $bdd->prepare('SELECT * FROM protection_indi order by ID_ProIn');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu d�roulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['ID_ProIn'];
			$intitule = $row['Nom_Pro'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
		
		$mess = $mess."</select>
		<input type=\"text\" name=\"Intitule\" style='text-transform:capitalize' />
		<input type=\"submit\" value=\"Modifier\" />
		</form><br/> </p>
		
		<p><strong>Voulez-vous supprimer un choix de protection individuelle?</strong></p>
		<form method=\"post\" action= \"PI.php\">
		<p>
		<select name=\"choix_util2\">";
		
		$req = $bdd->prepare('SELECT * FROM protection_indi');
		$req -> execute();
		$id = "";
		$intitule = "";
		foreach ($req as $row) {
			$id = $row['ID_ProIn'];
			$intitule = $row['Nom_Pro'];
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