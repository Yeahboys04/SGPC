<?php date_default_timezone_set("Europe/Paris");
session_start();

$mess = "<center><h3>Suppression d'une personne</h3>
<form method=\"post\" action=\"Suppr_admin.php\">
<p>
<select name=\"choix_pers\">";

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}

	// On trie tous les utilisateurs qui ne sont pas le compte SUPER-ADMIN
	$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE  id > 1 order by nom');
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
					
				Etes vous sur de vouloir supprimer cet administrateur?
				<input type=\"radio\" name=\"suppr\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
				<input type=\"radio\" name=\"suppr\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
  
					
					
				<input type=\"submit\" value=\"Valider\" />

				</form></center>";



include "Base.php";

?>