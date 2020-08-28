<?php date_default_timezone_set("Europe/Paris");


session_start();


	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}


if (isset($_POST['choix_pers'])) {
	
	if ($_POST['suppr'] == "non") {
		echo '<script>alert("Vous n\'avez pas validé");history.back();</script>';
	} else {
		try {
		$req = $bdd->prepare('UPDATE utilisateurs SET Habilitation = null WHERE ID = ?');
		$req -> execute(array($_POST['choix_pers']));
		echo '<script>alert("Vous avez bien repassé cet administrateur en simple membre");window.location.replace("Degrader_Admin.php");</script>';
		}catch (Exception $e){
			echo '<script>alert("Erreur");history.back();</script>';
	}
	
	
	}

} else {

	$mess = "<center><h3>Dégradation d'un Administrateur</h3><form method=\"post\" action=\"Degrader_Admin.php\">
<p>
<select name=\"choix_pers\">";

	$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE habilitation = "ADMIN" AND id > 1 order by nom');
	$req -> execute();
	$id = "";
	$nom = "";
	$prenom = "";
	
	foreach ($req as $row) {
		$id = $row['ID'];
		$nom = $row['NOM'];
		$prenom = $row['Prenom'];
		
		$mess = $mess."<option value=\"".$id."\">".$nom." ".$prenom."</option><br/>";

	}
	
$mess = $mess."</select> 
				</p>
					
				Etes vous sur de vouloir dégrader cet administrateur?
				<input type=\"radio\" name=\"suppr\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
				<input type=\"radio\" name=\"suppr\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
  
					
					
				<input type=\"submit\" value=\"Valider\" />

				</form></center>";

}
include "Base.php";

?>