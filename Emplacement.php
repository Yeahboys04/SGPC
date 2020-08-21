<?php date_default_timezone_set("Europe/Paris");
	session_start();
	// Ce module permet de créer une page qui permet à l'utilisateur de géréer les emplacements

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
	// Ajout d'un intitulé
	
	$inti = $_POST['Intitule_ajout'];
	$inti = ucfirst(strtolower($inti));

	
	
	
	$existe = $bdd -> prepare('SELECT * FROM Etagere WHERE Nom_Etagere = ?');
	$existe-> execute(array($inti));
	$existe = $existe->fetchColumn();
	if ($existe == 0 ) {

	
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select Etagere FROM Etagere order by Etagere');
		$req-> execute(Array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['Etagere'];
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
	
		$req = $bdd->prepare('INSERT INTO Etagere(Etagere,Nom_Etagere) VALUES (:nb,:inti)');
		$req->execute(array(
				'nb' => $id,
				'inti' => $inti,
				));
				echo '<script>alert("Insertion réussie");window.location.replace("Emplacement.php");</script>';
	}catch (Exception $e) {
		die('Erreur : ' . $e->getMessage());
	
		echo '<script>alert("Erreur dans l\'insertion ");history.back();</script>';
	}


} else {
	echo '<script>alert("Cet intitulé existe déjà");history.back();</script>';

}
} else {
		if (isset($_POST['choix_util'])) {
			if (isset($_POST['Intitule'])) {
					$id = $_POST['choix_util'];
					$inti = $_POST['Intitule'];
	
					try {
						$req = $bdd->prepare('UPDATE Etagere SET Nom_Etagere = ? WHERE Etagere = ?');
						$req -> execute(array($inti,$id));
						echo '<script>alert("Modification effectuée");window.location.replace("Emplacement.php");</script>';
					} catch (Exception $e) {
						echo '<script>alert("Erreur");history.back();</script>';
					}
			} else {
				echo '<script>alert("Champ de modification non rempli");history.back();</script>';
			}
		} else {
			if (isset($_POST['choix_util2'])) {
						if (!($_POST['choix_util2'] == 0 )){
						$id = $_POST['choix_util2'];

	
				try {
					$req = $bdd->prepare('DELETE FROM Etagere WHERE Etagere = ?');
					$req -> execute(array($id));
					echo '<script>alert("Suppression effectuée");window.location.replace("Emplacement.php");</script>';
				} catch (Exception $e) {
					echo '<script>alert("Erreur");history.back();</script>';
				}
			} else {
				echo '<script>alert("Champs de suppression non-remplis");history.back();</script>';
			}
		}else {
		
	
$mess = "<center><table cellspacing=40><tr><td><h2><center>Gestion des emplacements</center></h2></center>";

$mess = $mess."<center><p><strong>Voulez-vous ajouter un choix d'emplacement?</strong> </p>
		<form method=\"post\" action=\"Emplacement.php\">
			<input type=\"text\" name=\"Intitule_ajout\" style='text-transform:capitalize' />
			<input type=\"submit\" value=\"Ajouter\" />
		</form><br/>
		<p><strong>Voulez-vous modifier un choix d'emplacement?</strong></p>
		<form method=\"post\" action=\"Emplacement.php\">
		<p>
		<select name=\"choix_util\">
		<option value= 0 > Aucun </option><br/>";
		



		$req = $bdd->prepare('SELECT * FROM Etagere');
		$req -> execute();
		$id = "";
		$intitule = "";
		
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		foreach ($req as $row) {
			$id = $row['Etagere'];
			$intitule = $row['Nom_Etagere'];
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";

		}
		
		$mess = $mess."</select>
		<input type=\"text\" name=\"Intitule\" style='text-transform:capitalize' />
		<input type=\"submit\" value=\"Modifier\" />
		</form><br/> </p>
		
		<p><strong>Voulez-vous supprimer un choix d'emplacement?</strong></p>
		<form method=\"post\" action= \"Emplacement.php\">
		<p>
		<select name=\"choix_util2\">
		<option value= 0 > Aucun </option><br/>";
		
		// Menu déroulant pour la suppression
		$req = $bdd->prepare('SELECT * FROM Etagere');
		$req -> execute();
		$id = "";
		$intitule = "";
		foreach ($req as $row) {
			$id = $row['Etagere'];
			$intitule = $row['Nom_Etagere'];
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