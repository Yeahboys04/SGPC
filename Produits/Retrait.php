<?php date_default_timezone_set("Europe/Paris");

//Cette partie permet de gèrer les retraits avec le formulaire remplis précédemment.

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

									
	if (!isset($_GET['id'])) {
		echo '<script>alert("Veuillez passer par les moyens mis à votre disposition");window.location.replace("../Fiche_Perso.php");</script>';
	} else {
		$id_produit = $_GET['id'];
		if (!(is_Numeric($_POST['Quantite']))) {
			echo '<script>alert("La quantité doit être un nombre");history.back();</script>';
		} else {
		$quantite = $_POST['Quantite'];
		if ($_POST['Id_utilisation'] == 0 ) {
			echo '<script>alert("Vous n\'avez pas choisi d\'utilisation");history.back();</script>';
			} else {
				$util = $_POST['Id_utilisation'];
				if (!(is_Numeric($_POST['Temps']))) {
					echo '<script>alert("Le temps d\'utilisation doit être un nombre");history.back();</script>';
					} else {
							//Gestion des risques : on regarde si un risque est cochée, si oui, on ajoute son intitulé à la liste
							$risques = "";
							$ris = $bdd->prepare('SELECT * FROM risques order by Intitule_ris');
							$ris -> execute();
							$compteur = 0;
							foreach ($ris as $row) {
								$risq = "Risque".$row['Id_risque'];
								if (isset($_POST[$risq])) {
									if ($compteur == 0 ) {
										$risques = $row['Intitule_ris'];
									} else {
										$risques = $risques." / ".$row['Intitule_ris'];
									}
									$compteur = 1;
								}
							} // Si aucun n'est coché, on passe "Risques" à "Aucun".
							if ($compteur == 0 ) {
								$risques = "Aucun";
							}
							//Gestion des protections individuelles
							$protInd = "";
							$pi = $bdd->prepare('SELECT * FROM protection_indi ORDER BY Nom_Pro');
							$pi -> execute();
							$compteur = 0;
							foreach ($pi as $row) {
								$proi = "PI".$row['ID_ProIn'];
								if (isset($_POST[$proi])) {
									if ($compteur ==0) {
										$protInd = $row['Nom_Pro'];
									} else {
										$protInd = $protInd." / ".$row['Nom_Pro'];
									}
									$compteur = 1;
								}
							}
							if ($compteur == 0 ) {
								$protInd = "Aucune";
							}
							//Gestion des protections communes
							$protComm = "";
							$pc = $bdd->prepare('SELECT * FROM protection_comm order by Nom_Prot');
							$pc -> execute();
							$compteur = 0;
							foreach ($pc as $row) {
								$proc = "PC".$row['Id_protC'];
								if (isset($_POST[$proc])) {
									if ($compteur == 0) {
										$protComm = $row['Nom_Prot'];
									} else {
										$protComm = $protComm." / ".$row['Nom_Prot'];
									}
									$compteur = 1;
								}
							}
							if ($compteur == 0 ) {
								$protComm = "Aucune";
							}						
							
							$commentaires = $_POST['Commentaire'];
		
		$mess = "";


		function new_ID($bdd) {
		$trouve = 0;
		$nb = 1;
		$req = $bdd->prepare('Select Id_Retrait FROM retrait order by Id_Retrait');
		$req-> execute(array()); 
		foreach ($req as $row) {
			if ($trouve == 0) {
				$id = $row['Id_Retrait'];
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
	$idre = new_ID($bdd);
	
		
	$qures = $bdd->prepare('SELECT * FROM produits WHERE Id_Produit = ?');
	$qures -> execute(array($_GET['id']));
	
	$qu = 0;
	foreach($qures as $row) {
		
		$qu = $row['Quantite'];
	}

	
	if ($qu - $quantite < 0) {
		echo '<script>alert("Vous ne pouvez pas retirer autant. Quantité maximum possible : '.$qu.'Veuillez modifier votre choix.");history.back();</script>';
	} else {
		try {
		$prod = $bdd->prepare('UPDATE Produits SET Quantite = ? WHERE Id_Produit = ?');
		$prod -> execute(array($qu - $quantite,$id_produit));
		
		$retrait = $bdd->prepare('INSERT INTO Retrait(ID,Id_Produit,Date_Retrait,Temps_utilisation,Id_utilisation,Risques,Quantite,Prot_in,Prot_comm,Commentaire,Id_Retrait)
		values (:id,:idp,CURRENT_DATE,:tu,:idu,:idr,:qu,:pi,:pc,:comm,:idre)');
		
		$retrait -> execute(array(
				'id' => $_SESSION['id'],
				'idp' => $id_produit,
				'tu' => $_POST['Temps'],
				'idu' => $util,
				'idr' => $risques,
				'qu' => $quantite,
				'pi' => $protInd,
				'pc' => $protComm,
				'comm' => $commentaires,
				'idre' => $idre
				
				));
				echo '<script>alert("Vous avez bien retiré '.$quantite.'g/ml du produit concerné");window.location.replace("../Retrait.php");</script>	';
		} catch (Exception $e) {
			
			echo '<script>alert("Erreur dans le retrait");history.back();</script>';
		}
	
		}
		}
		
		
		
					}	
				}
			}	
		
	