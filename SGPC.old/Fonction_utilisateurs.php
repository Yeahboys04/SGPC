<?php date_default_timezone_set("Europe/Paris");

	/*
	**
	**  Cette fonction display le module de changement de mot de passe
	**  Elle permet ensuite de réaliser la modification par la suite, avec le fichier "Modif_Mdp.php"
	**
	*/



	function moduleFiche($id,$bdd) {
		$mess = "<hr><br/><center><strong>Fiche de suivi </strong></center><br/>
		<form action=\"Fiche_Suivi.php?id=".$id."\" method=\"post\">
			 Période sur laquelle vous souhaitez faire le releve des retraits : 
				du  : 1er"; 

		$annee_max = date("Y");
		

		
	
		
		$mess = $mess."<select name=\"choix_mois1\">";
		$mess = $mess."<option value=\"1\">Janvier</option>";
		$mess = $mess."<option value=\"2\">Février</option>";
		$mess = $mess."<option value=\"3\">Mars</option>";
		$mess = $mess."<option value=\"4\">Avril</option>";
		$mess = $mess."<option value=\"5\">Mai</option>";
		$mess = $mess."<option value=\"6\">Juin</option>";
		$mess = $mess."<option value=\"7\">Juillet</option>";
		$mess = $mess."<option value=\"8\">Août</option>";
		$mess = $mess."<option value=\"9\">Septembre</option>";
		$mess = $mess."<option value=\"10\">Octobre</option>";
		$mess = $mess."<option value=\"11\">Novembre</option>";
		$mess = $mess."<option value=\"12\">Décembre</option>";

		$mess = $mess."<select>";
		
		
		$mess = $mess."<select name=\"choix_date1\">";
	
		//Menu déroulant pour la modification, on place un champ texte pour modifier le champ saisie.
		
		for($annee_max = $annee_max+1; $annee_max >2011; $annee_max--) {
			$mess = $mess."<option value=\"".$annee_max."\">".$annee_max."</option><br/>";

		}
		
		$mess = $mess."</select>
		&nbsp&nbsp au  1er";

		$mess = $mess."<select name=\"choix_mois2\">";
		$mess = $mess."<option value=\"1\">Janvier</option>";
		$mess = $mess."<option value=\"2\">Février</option>";
		$mess = $mess."<option value=\"3\">Mars</option>";
		$mess = $mess."<option value=\"4\">Avril</option>";
		$mess = $mess."<option value=\"5\">Mai</option>";
		$mess = $mess."<option value=\"6\">Juin</option>";
		$mess = $mess."<option value=\"7\">Juillet</option>";
		$mess = $mess."<option value=\"8\">Août</option>";
		$mess = $mess."<option value=\"9\">Septembre</option>";
		$mess = $mess."<option value=\"10\">Octobre</option>";
		$mess = $mess."<option value=\"11\">Novembre</option>";
		$mess = $mess."<option value=\"12\">Décembre</option>";
		$mess = $mess."<select>";
		
		
		$annee_max = date("Y");
		$mess = $mess."<select name=\"choix_date2\">";
	
	
		for($annee_max = $annee_max+1; $annee_max >2011; $annee_max--) {
			$mess = $mess."<option value=\"".$annee_max."\">".$annee_max."</option><br/>";

		}
		
		$mess = $mess."</select>
		<input type=\"submit\" value=\"Generer\" />
		</form><br/>";
		
	
	
		return $mess;
	}


	// Cette fonction permet de renvoyer un module permettant le passage d'un membre en administrateur


	function modulePassageAdmin($id,$bdd) {
		
		$mod = "";
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ? AND habilitation = "ADMIN"');
		$req -> execute(array($id));
		$admin = $req->fetchColumn();
		
		
		if ($admin == 0)  {
			
			$mod = "<center><form action=\"Pass_Admin.php?id=".$id."\" method=\"post\">
				Voulez-vous passer cet utilisateur en tant qu'administrateur
				<input type=\"radio\" name=\"ad\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
				<input type=\"radio\" name=\"ad\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
				  
				<input type=\"submit\" value=\"Valider\" /> </form></center>";
			}
		
		return $mod;
	}
		
	// Cette fonction affiche le module permettant la modification du mot  de passe
	
	function moduleModifMdp($id) {
		
		$mod = "<center><br/>
				<strong>Changement de mot de passe </strong>
				<form action=\"Modif_Mdp.php?id=".$id."\" method=\"post\">
				<p>
				
				Veuillez taper le nouveau mot de passe
				</p>
				<p>
					<input type=\"password\" name=\"Mdp\" />
				</p>
				  
				 <p>
				Veuillez taper une nouvelle fois le nouveau mot de passe
				</p>
				<p>
					<input type=\"password\" name=\"Mdp2\" />
				</p>
				
				  
				<input type=\"submit\" value=\"Valider\" />

				</form></center>";
	
		return $mod;
	}
	
	//Ce module affiche un cadre permettant la suppression de l'utilisateur
	
	function moduleSuppression($id,$bdd) {

	
		$mod = "";
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ? AND habilitation = "ADMIN"');
		$req -> execute(array($id));
		$admin = $req->fetchColumn();
		
		
		if (!($admin == 0))  {
			if ($_SESSION['Admin'] == 2) {
				$mod = "<center><form action=\"Suppr_user.php?id=".$id."\" method=\"post\">
				Voulez-vous supprimer cet administrateur?<br/>
				/!\Attention, n'oubliez pas d'imprimer la fiche de suivi auparavant! /!\
				<input type=\"radio\" name=\"suppr\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
				<input type=\"radio\" name=\"suppr\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
				  
				<input type=\"submit\" value=\"Valider\" /> </form></center>";
				
			}
		}else {
			$mod = "<center><form action=\"Suppr_user.php?id=".$id."\" method=\"post\">
				Voulez-vous supprimer cet utilisateur?
				/!\Attention, n'oubliez pas d'imprimer la fiche de suivi auparavant! /!\
				<input type=\"radio\" name=\"suppr\" value=\"oui\" id=\"oui\"  /> <label for=\"oui\">Oui</label>
				<input type=\"radio\" name=\"suppr\" value=\"non\" id=\"non\" checked=\"checked\"/> <label for=\"non\">Non</label>
				  
				<input type=\"submit\" value=\"Valider\" /> </form></center>";
			}
		
		return $mod;
	}
							

	
	/*
	**
	**	Cette fonction prend en paramètre une ID et une base de données
	**	Elle permet d'obtenir l'historique des 10 derniers retraits de la personne.
	**
	*/
	
	function histo_perso_retrait($id,$bdd) {
		$histo = "<center><br/>
			Les derniers retraits effectués sont : ";
		$histo = $histo."<table cellspacing = 30><th>Produit</th><th>Date</th><th>Temps d'utilisation</th><th>Utilisation</th><th>Risques</th><th>Quantite</th><th>Protections</th><th>Commentaire</th>";
		$req = $bdd -> prepare('SELECT * FROM retrait WHERE ID = ? ORDER BY Date_Retrait DESC');
		$req -> execute(array($id));
		$compteur = 0;
		foreach ($req as $row) {
			if ($compteur < 10 ) {
				$histo = $histo."<tr><td align=center>";
				$req2 = $bdd->prepare('SELECT * FROM Produits WHERE Id_Produit = ?');
				$req2 -> execute(array($row['Id_Produit']));
				foreach ($req2 as $row2) {
					$histo = $histo.$row2['Nom_Produit']."</td><td align=center>";
				}
				$histo = $histo.$row['Date_Retrait']."</td><td align=center>";
				$histo = $histo.$row['Temps_utilisation']."</td><td align=center>";
				
				$req3 = $bdd->prepare('SELECT * FROM utilisations WHERE Id_utilisation = ?');
				$req3 -> execute(array($row['Id_utilisation']));
				foreach ($req3 as $row3) {
					$histo = $histo.$row3['Intitule_uti']."</td><td align=center>";
				}
				
				$histo = $histo.$row['Risques']."</td><td align=center>";
				$histo = $histo.$row['Quantite']."</td><td align=center>";
				$histo = $histo.$row['Prot_in']."<br/>".$row['Prot_comm']."</td><td align=center>";
				$histo = $histo.$row['Commentaire'];
				$histo = $histo."</td></tr>";
			}
				
		}
			$histo = $histo."</table>";
			

		$histo = $histo."</center>";
		return $histo;
	
	}



?>