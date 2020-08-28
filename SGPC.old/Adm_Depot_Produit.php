<?php date_default_timezone_set("Europe/Paris");
session_start();
$mess = "<h2><center>Dépot d'un produit</center></h2><br/><br/>";

	try
	{
		$pdo_options[PDO::ATTR_ERRMODE] = PDO::ERRMODE_EXCEPTION;
		$bdd = new PDO('mysql:host=localhost;dbname=produits_chimiques', 'root','root', $pdo_options);
	}
	catch (Exception $e)
	{
			die('Erreur : ' . $e->getMessage());
	
	}

	
	$mess =$mess."<center><form action=\"Produits/Depot.php\" method=\"post\">
		Produit à selectionner : &nbsp
		<select name=\"ID_Produit\">";
		
		$req = $bdd->prepare('SELECT * FROM produits');
		$req -> execute();
		$id = "";
		$intitule = "	";
		

		foreach ($req as $row) {
			$id = $row['Id_Produit'];
			$intitule = $row['Nom_Produit']."&nbsp&nbsp&nbsp Num_Cas : ".$row['Num_Cas']."&nbsp&nbsp&nbsp&nbspPureté :  ";
			if (!($row['Purete']=="")) {
			
			$intitule = $intitule.$row['Purete']."&nbsp&nbsp&nbsp&nbsp ";
			} else {
				$intitule = $intitule." N/A &nbsp&nbsp&nbsp&nbsp";
			}

			$intitule = $intitule."Propriétaire : ";
			if (!($row['ID'] == null )) {
				$intitule = $intitule.$row['ID'];				}
			 else {
				$intitule = $intitule." N/A &nbsp&nbsp&nbsp&nbsp";
			}

				$nom_lieu = "";
				$req2 = $bdd->prepare('SELECT * FROM lieu WHERE Id_lieu = ?');
				$req2 -> execute(array($row['Id_lieu']));
				foreach($req2 as $row2) {
					$nom_lieu = $row2['Nom_lieu'];
					$intitule= $intitule." Lieu : ".$nom_lieu;
				}
			
			
			$mess = $mess."<option value=\"".$id."\">".$intitule."</option><br/>";
			
			
		}
		
		$mess = $mess."</select></center><br/><center><br/>
		Quantité à déposer <input type=\"text\" name = \"Quantite\"> g OU mL
		<input type=\"submit\" value =\"Ajouter\"></center></form><br/><br/>";
		
		include "Base.php";


?>