
<?php date_default_timezone_set("Europe/Paris");

	session_start();
	if (!($_SESSION['Admin'] == 0)) {
			// Seul les admins ont accès a cette zone
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	
	
	$id = $_GET['id'];
	
	$nom = $_POST['Nom'];
	
	$num = $_POST['NCas'];
		
	$form = $_POST['Formule'];
			
	$etat = $_POST['Etat'];
	$purete = $_POST['Purete'];
				
	$risques = $_POST['Risques'];
	$symboles = "";
	$conseils = $_POST['Conseils'];
	if (isset($_POST['Modification'])) {
						$symboles = "<strong><h3>".$_POST['Type_Danger']."</h3></strong><br/><center>";
				$compteuur = 0;
				if (isset($_POST['SGH01']))  {
					
					$symboles = $symboles."<img src=\"Pictos/explos.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				if (isset($_POST['SGH02']))  {
					
					$symboles = $symboles."<img src=\"Pictos/flamme.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				if (isset($_POST['SGH03']))  {
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/rondflam.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}
				if (isset($_POST['SGH04']))  {
					
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/bottle.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}if (isset($_POST['SGH05']))  {
				
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/acid.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}if (isset($_POST['SGH06']))  {
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/skull.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}if (isset($_POST['SGH07']))  {
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/exclam.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}if (isset($_POST['SGH08']))  {
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/silhouet.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}if (isset($_POST['SGH09']))  {
					
					if ($compteur == 3) {
						echo '<script>alert("Vous ne pouvez sélectionner que les deux pictogrammes principaux!");history.back;</script>';
					} else{
					$symboles = $symboles."<img src=\"Pictos/pollut.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				}
				$symboles = $symboles."</center>";
			} else {
				$req = $bdd->prepare('SELECT * FROM produits WHERE ID_Produit = ?');
				$req -> execute(array($id));
				foreach ($req as $row) {
					$symboles = $row['Symbole'];
				}
			}
				

					
	$C = $_POST['C'];
	$M = $_POST['M'];
	$R = $_POST['R'];

							
	$lieu = $_POST['Lieu'];
	if ($lieu == 0) {
		echo '<script>alert("Vous devez choisir un lieu de stockage");history.back();</script>';
	}else {
	$sl = $_POST['sous_lieu'];
		$commentaires = $_POST['Observation'];
		$proprio = $_POST['Proprietaire'];
		$fournisseur = $_POST['Fournisseur'];
			if (!(is_Numeric($_POST['Quantite']))) {
				echo '<script>alert("La quantité doit être un nombre");history.back();</script>';
			} else {
				$quantite = $_POST['Quantite'];	
									
										try{
										
											echo $quantite;
											$req = $bdd->prepare('UPDATE Produits 
																SET Num_Cas = ?,
																Nom_Produit = ?,
																Form_Chimique = ?,
																Id_etat = ?,
																Purete = ?,
																Phrases_risques = ?,
																Phrases_conseil = ?,
																Symbole = ?,
																Id_lieu = ?,

					Etagere = ?,
																ID = ?,
																Fournisseur =?,
																Quantite = ?,
																C = ?,
																M = ?,
																R = ?,
																Observations = ?
																
																WHERE Id_Produit = ?
																');
											$req -> execute(array($num,$nom,$form,$etat,$purete,$risques,$conseils,$symboles,$lieu,$sl,$proprio,$fournisseur,$quantite,$C,$M,$R,$commentaires,$id));
											echo '<script>alert("Modification du produit réussie");window.location.replace("../Adm_Modifier_Produit.php");</script>';
										
											$_SESSION['Modif'] = 0;
										
										}catch (Exception $e) {
											die('Erreur : ' . $e->getMessage());
											echo '<script>alert("Erreur dans la modification");history.back();</script>';
										}
											
									
								}
							}
		} else {
	echo '<script>alert("Vous ne pouvez pas faire ça");window.location.replace("Fiche_Perso.php");</script>';
}


?>
