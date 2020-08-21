<?php date_default_timezone_set("Europe/Paris");
session_start();



	// Si le membre n'est pas administrateur
	if (($_SESSION['Admin'] < 1 )) {
		echo '<script>alert("Vous n\'êtes pas administrateur!");window.location.replace("Fiche_Perso.php");</script>';
	}
	else {
	
			// Connexion à la base de données.

			
	if (isset($_POST['Nom'])) {
		try {		
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
		$nom =  strtoupper($_POST['Nom']);
	$prenom = ucfirst($_POST['Prenom']);
	
	
	//Cette fonction permet de trouver la première ID libre après 1
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select id FROM utilisateurs order by id');
		$req-> execute(Array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['id'];
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
	
	
	//On vérifie si l'utilisateur existe déjà ou non
	$req = $bdd-> prepare('SELECT * FROM utilisateurs WHERE nom = ? AND prenom = ?');
	$req -> execute(array($nom,$prenom));
	$nb = $req->fetchColumn();
	if (!($nb == 0)) {
		echo '<script>alert("Cet utilisateur existe déjà");history.back(-1);</script>';
	}else {
	
	$cle = $nom.".".strtolower($prenom);
	$cle = MD5($cle);
	$id = new_ID($bdd);
	$ad = null;
	if ($_POST['admin'] == 'oui') {
		$ad = "ADMIN";
	}
	if (!(strlen($_POST['Datenaiss']) == 10)) {
		echo '<script>alert("Format de date incorrecte");history.back();</script>exit()';
	} else {
	$datenaiss = $_POST['Datenaiss'];
	

	$mat = null;
	$activite = $_POST['choix'];
	
	try {
	
	// Insertion dans la base
	$req = $bdd-> prepare('INSERT INTO utilisateurs(id,nom,prenom,hach,habilitation,Date_naiss,Matricule,Activite) 
	VALUES (:nb,:nom,:prenom,:cle,:admin,:date,:mat,:act)');
		$req->execute(array(
				'nb' => $id,
				'nom' => $nom,
				'prenom' => $prenom,
				'cle' => $cle,
				'admin' => $ad,
				'date' => $datenaiss,
				'mat' => $mat,
				'act' => $activite
				));
				echo '<script>alert("Insertion réussie");window.location.replace("Fiche_Perso.php?id='.$id.'")</script>';
	}catch (Exception $e) {
		echo '<script>alert("Erreur dans l\'insertion");history.back();</script>';
	}

	
	}
}
		
		
	} else {		

	
	$mess = " <center><strong>Ajout d'un utilisateur</strong><br/><p>Veuillez taper le nom du futur utilisateur

<form action=\"Ajout_Utilisateur.php\" method=\"post\">
<p>
    <input type=\"text\" name=\"Nom\" required=\"required\" style='text-transform:uppercase' />
</p>
	<p>
Veuillez taper son prenom
</p>
<p>
	<input type=\"text\" name=\"Prenom\" required=\"required\" style='text-transform:capitalize' />
  </p>  

Date de Naissance (AAAA-MM-JJ) :  <input type=\"text\" name=\"Datenaiss\" required=\"required\" />

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
	$mess = $mess."<option value=\"".$row['Nom_Activite']."\">".$row['Nom_Activite']."</option>";
}
$mess = $mess."</select>
  <br/>
  <br/>
Est-il admin?
<input type=\"radio\" name=\"admin\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
<input type=\"radio\" name=\"admin\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
  <br/><br/>
  <input type=\"submit\" value=\"Valider\" />

</form></center>";

	include "Base.php";
}
}
?>