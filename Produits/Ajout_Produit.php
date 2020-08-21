<?php date_default_timezone_set("Europe/Paris");
	session_start();
	if (!($_SESSION['Admin'] == 0)) {
	
	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	}
	
	
	function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select Id_Produit FROM produits order by Id_Produit');
		$req-> execute(array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['Id_Produit'];
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
	
	$nom = $_POST['Nom'];
	if ($nom == null) {
		echo '<script>alert("Vous n\'avez pas rempli le champ nom");history.back();</script>';
	} else {
		
		$num = $_POST['NCas'];
		if ($num == null) {
			echo '<script>alert("Vous n\'avez pas rempli le champ Numéro Cas");history.back();</script>';
		} else{
			
			$form = $_POST['Formule'];
			if ($form == null) {
				echo '<script>alert("Vous n\'avez pas rempli le champ formule");history.back();</script>';
			} else {
				
				$etat = $_POST['Etat'];
				$purete = $_POST['Purete'];
				if ($purete == null ) {
					$purete = "";
				}
				
				
				$risques = $_POST['Risques'];


				$conseils = $_POST['Conseils'];

				$symboles = "<strong><h3>".$_POST['Type_Danger']."</h3></strong><br/><center>";
				$compteur = 0;
				if (isset($_POST['SGH01']))  {
					
					$symboles = $symboles."<img src=\"Pictos/explos.jpg\" alt=\"Image explos\" width = 10% height = 10% />&nbsp&nbsp&nbsp";
				}
				if (isset($_POST['SGH02']))  {
					$compteur = $compteur + 1;
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
				
				

							
							
							$c = $_POST['C'];
							$m = $_POST['M'];
							$r = $_POST['R'];
							$obs = $_POST['Observation'];
							$fournisseur = $_POST['Fournisseur'];
							if ($fournisseur == null) {
								$fournisseur = "Non-renseigné";
							}
							$sous_lieu = $_POST['Sous_lieu'];
							$lieu = $_POST['Lieu'];
							if ($lieu == 0) {
								echo '<script>alert("Vous devez choisir un lieu de stockage");history.back();</script>';
							} else {
					
								$proprio = $_POST['Proprietaire'];
								$quantite = $_POST['Quantite'];
								if ($quantite == null ) {
									echo '<script>alert("Vous devez entrer une quantité");history.back();</script>';
									
								} else {
													
										
										try{
										$req = $bdd->prepare('SELECT * FROM Produits WHERE Num_Cas = ? AND Purete = ? AND Id_etat = ? AND ID = ? AND Id_lieu = ? AND Etagere = ?');
										$req -> execute(array($num,$purete,$etat,$proprio,$lieu,$sous_lieu ));
										$nb = $req->fetchColumn();
										
										if (!($nb == 0 )) {
											
											foreach ($req as $row) {
												$quantite = $quantite + $row['Quantite'];
												$req = $bdd->prepare('UPDATE Produits SET Quantite = ? WHERE Id_Produit = ?');
												$req -> execute(array($quantite,$row['Id_Produit']));
												
												echo '<script>alert("Quantité ajoutée au produit déjà existant de cette pureté à ce lieu et appartenant à la personne demandée.");
													window.location.replace("../Adm_Ajouter_Produit.php");
													</script>';
												
												} 
											} else {
										$req = $bdd-> prepare('INSERT INTO produits(Id_Produit,Num_Cas,Nom_Produit,Form_Chimique,Id_etat,Purete,Phrases_risques,Phrases_conseil,Symbole,Id_lieu,Etagere,ID,Fournisseur,Quantite,C,M,R,Observations) VALUES (:id,:numcas,:nomp,:form,:etat,:purete,:ris,:cons,:symb,:lieu,:et,:pers,:fourn,:qu,:c,:m,:r,:ob)');

										
										$req->execute(array(
												'id' => $id,
												'numcas' => $num,
												'nomp' => $nom,
												'form' => $form,
												'etat' => $etat,
												'purete' => $purete,
												'ris' => $risques,
												'cons' => $conseils,
												'symb' => $symboles,
												'lieu' => $lieu,

	'et' => $sous_lieu,
												'pers' => $proprio,
												'fourn' => $fournisseur,
												'qu' => $quantite,
												'c' => $c,
												'm' => $m,
												'r' => $r,
												'ob' => $obs
												)); 
										
										echo '<script>alert("Insertion du produit réussie");window.location.replace("../Adm_Ajouter_Produit.php");</script>'; 
										
										}
												}catch (Exception $e) {
											//die('Erreur : ' . $e->getMessage());
											echo '<script>alert("Erreur dans l\'insertion");history.back();</script>';
										}
									
						
					}
				}
			}
		}
	} 
}



?>