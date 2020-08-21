<?php

if (!($_SESSION['connexion_en_cours'] == 1)) {
//Si l'utilisateur n'est pas connecté, il est renvoyé à l'acceuil
if ($_SESSION['id'] == null ) {
	echo '<script>alert("Vous n\'etes pas connecte");window.location.replace("Accueil.php");</script>';
	
}
}
$_SESSION['connexion_en_cours'] = 0 ;
// On sauvegarde le temps courant. Au dela d'une heure, tout le monde est déconnecté.

	if(isset($_SESSION['timestamp'])){ 					// si $_SESSION['timestamp'] existe
             if($_SESSION['timestamp'] + 3600 > time()){ 
                    $_SESSION['timestamp'] = time();
             }else{ 
				session_destroy();
				echo '
			<script> alert("Délai de connexion dépassé");  
			window.location.replace("Accueil.php");
			</script>';
				
			}
	 }
	else{ 
		$_SESSION['timestamp'] = time(); 
}
	


?>


<!DOCTYPE html>
<html>
    <head>
        
        <meta charset="iso-8859-1\n" />
		<link rel="stylesheet" href="Style.css" />
        <title>S.G.P.C.</title>
		<!--[if lt IE 9]>
		<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
		<![endif]-->
		
    </head>

    <body>
        
	<!---						Haut de la page																					-->
	<!---						Barre de connexion/deconnexion.																	-->
	
	<?php
	
	if (!($_SESSION['id'] == 0 )) {
		echo '<header title=\"Connexion\">';
		include "Bordereau_connecte.php";
		echo '</header>';
	}
	?>
	
	
	
	<!---						Fin de la barre de co/deco																		-->

	<!--						Bannière d'accueil																				-->
	
	
	<header>
	
	<p>
	<center>
	<h1>S.G.P.C.</h1>
	<h3>Système de Gestion de Produits Chimiques</h3>
	</p>
		
	<!--						Fin de la bannière d'accueil	-->
	</header>
	<!---						Fin du haut																						-->
	
	
	<!---                       Partie gauche																					--->
	
	
	
	<?php
		if (!($_SESSION['id'] == 0 )) {
			echo '<nav>';
			include "Menu.php";
			echo '</nav>';
	}
	?>
	
	
	
	
	<!---					 	Partie droite																					--->
	
	<section>
	
	<?php
	
		echo $mess;
		
	?>
		
    </body>
</html>