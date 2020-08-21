<?php date_default_timezone_set("Europe/Paris");
session_start();
if ($_SESSION['Admin'] == 0) {

	// Seul un administrateur a droit a cette base, on vérifie donc ceci.
	echo '<script>alert("Vous n\'avez pas l\'autorisation.");window.location.replace("Fiche_Perso.php");</script>';
}

$mess = '<center><br/>Liste des utilisateurs<br/></center>';


try
{
	$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
	$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
}
catch (Exception $e)
{
        die('Erreur : ' . $e->getMessage());
}
	
	
	
	function affiche_fiche($id,$bdd) {
		//Cette fonction affiche une ligne d'un tableau regroupant les infos d'un utilistaure
		
		
		$mess2= "<tr><td >".$id;
		
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$req -> execute(Array($id));
		foreach($req as $row) {
			$mess2 = $mess2."</td><td>".$row['NOM']."</td><td>".$row['Prenom']."</td>";
		
		if ($row['Habilitation'] == 'ADMIN') {
			$mess2 = $mess2."<td>ADMINISTRATEUR</td>";
		}else {
			$mess2 = $mess2."<td></td>";
		}
		$mess2 = $mess2."<td><a href=\"Fiche_Perso.php?id=".$id."\">Consultation Fiche</a></td>";
		
		$mess2 = $mess2."</tr>";
		
		}	
	
		return $mess2;	
	
	}
	
	
	
	
// On selectionne toutes les ID présentes dans la base triés par nom de famille

		$request = $bdd->prepare('Select id FROM utilisateurs order by nom');
		$request->execute();
		$tableau = "<center><table cellspacing=50><th>ID</th><th>Nom</th><th>Prenom</th><th>Habilitation</th>";
		//Pour chaque ID on appelle affiche_ligne, qui permet l'affichage d'une ligne du tableau.
		foreach ($request as $row) {
			$id = $row['id'];
			if ($id >1) {
			$ligne = affiche_fiche($id,$bdd);
			
			$tableau = $tableau.$ligne;
			}
		}
		$tableau = $tableau."</table></center>";
		$mess = $mess."<br/><br/>".$tableau;
		
		include "Base.php";
	



?>