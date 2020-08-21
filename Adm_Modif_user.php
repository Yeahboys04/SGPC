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
	
	
if(!(isset($_POST['choix']))) {

$mess = "<center><br/>
Quel utilisateur souhaitez vous modifier?
<br/><br/>
<form method=\"post\" action=\"Adm_Modif_user.php\">
<p>
<select name=\"choix\">
    	
";



	$req = $bdd->prepare('SELECT * FROM utilisateurs order by nom');
	$req -> execute();
	$id = "";
	$nom = "";
	$prenom = "";
	
	foreach ($req as $row) {
		$id = $row['ID'];
		$nom = $row['NOM'];
		$prenom = $row['Prenom'];
		if (!(($row['NOM'] == 'ADMIN')&&($row['Prenom'] =='Admin'))) {
		$mess = $mess."<option value=\"".$id."\">".$nom." ".$prenom."</option><br/>";

		}
	}
	
$mess = $mess."</select> 

				<input type=\"submit\" value=\"Valider\" />

				</form></center>";
				include "Base.php";
}else{
	if (!(isset($_POST['Nom']))) {
	$mess = "<center><h4>Modification d'un utilisateur </h4><br/><br/>";
	$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE ID = ?');
	$req -> execute(array($_POST['choix']));
	$nom = "";
	$prenom = "";
	$datenaiss = null;
	$matricule = "";
	$activite = "";
	$admin = null;
	foreach ($req as $row) {
		$nom = $row['NOM'];
		$prenom = $row['Prenom'];
		$datenaiss = $row['Date_naiss'];
		$matricule = $row['Matricule'];
		$activite = $row['Activite'];
		$admin = $row['Habilitation'];
	}
	
	$mess = $mess."<form action=\"Adm_Modif_user.php?id=".$_POST['choix']."\" method=\"post\">
<p>
    Nom<input type=\"text\" name=\"Nom\" value = \"".$nom."\" required=\"required\" style='text-transform:uppercase' />
</p>
	<p>
Veuillez taper son prenom
	<input type=\"text\" name=\"Prenom\" value = \"".$prenom."\" required=\"required\" style='text-transform:capitalize' />
  </p>  

Date de Naissance (JJ/MM/AAAA) :  <input type=\"text\" name=\"Datenaiss\" value = \"".$datenaiss."\" required=\"required\"/>

<br/>
<br/>
Matricule :   <input type=\"text\" name=\"Matricule\" value = \"".$matricule."\" required=\"required\" />
<br/>
<br/>
Activite : <select name=\"choix\"> ";
try {		
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}

$req = $bdd->prepare('SELECT * FROM Activite ORDER By Nom_Activite');
$req -> execute();
$mess = $mess."<option value=\"Aucun\">Aucun</option>";
foreach ($req as $row) {
	if ($row['Nom_Activite'] == $activite) {
		$mess = $mess."<option value=\"".$row['Nom_Activite']."\" selected=\"selected\" >".$row['Nom_Activite']."</option>";
	} else {

	$mess = $mess."<option value=\"".$row['Nom_Activite']."\">".$row['Nom_Activite']."</option>";
}
}
$mess = $mess."</select>

  <br/><br/>
  <br/>

  <input type=\"submit\" value=\"Valider\" />

</form></center>";
include "Base.php";
	
} else {

	$id = $_GET['id'];
	$req = $bdd->prepare('UPDATE utilisateurs SET NOM = ?,
				Prenom = ?,
				Date_naiss = ?,
				Matricule = ?,
				Activite = ?
				WHERE ID = ?');
	try {
	$req -> execute(array($_POST['Nom'],$_POST['Prenom'],$_POST['Datenaiss'],$_POST['Matricule'],$_POST['choix'],$id));
	echo '<script>alert("Modification réussie");window.location.replace("Fiche_Perso.php?id='.$id.'");</script>';
	
	} catch (Exception $e) {
		echo '<script>alert("Problème dans la modification");history.back();</script>';
	}

	
	
}
}



?>
