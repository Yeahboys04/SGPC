<?php date_default_timezone_set("Europe/Paris");

	function connexion($nom,$cle,$bdd) {
		$id = 0;
		$nb = $bdd->prepare('SELECT * FROM utilisateurs WHERE NOM = ? AND hach = ?');
		$nb ->execute((array($nom,$cle)));
		$nb = $nb->fetchColumn();
		if (!($nb == 0) ) {
			$id = returnId($nom,$cle,$bdd);
		}
		return $id;
	}
	
	
	function returnId($nom,$cle,$bdd) {
	$req = $bdd->prepare('Select id FROM utilisateurs WHERE nom = ? And hach = ?');
	$req-> execute(Array($nom,$cle));
	foreach ($req as $row) {
		$id = $row['id'];
	}
	
	return $id;
	
	}

	function isAdmin($id,$bdd) {
	
		// Si c'est un administrateur commum : valeur 1.
		//Si c'est le compte ADMIN : valeur 2.
	
		$admin = 0; //Si l'user n'est âs Admin, $admin prend la valeur 0
		
		$req = $bdd->prepare('SELECT * FROM utilisateurs WHERE id = ?');
		$req -> execute(array($id));
		foreach ($req as $row) {
			if ($row['NOM'] == 'ADMIN') {
				if ($row['Prenom'] == 'Admin') {
					$admin = 2;
					echo '<script>alert("Je suis super Admin");</script>';
				}
			}
				else {
				if ($row['Habilitation'] == 'ADMIN') {
				$admin = 1;
			}
		}
		}
		return $admin;
	}
				














?>