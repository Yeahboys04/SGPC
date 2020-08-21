<?php date_default_timezone_set("Europe/Paris");
session_start();
$_SESSION['id'] = 0;
$_SESSION['connexion_en_cours'] = 1 ;
// Ce fichier php permet de générer la page de connexion.

$mess =  "

	<center><h1> Bienvenue sur le S.G.P.C. </h1>
					
				<br/><br/>
				<h3> Veuillez vous connecter</h3>

				
				<p> 
				
				Veuillez taper votre nom : 
				
				</p>

				<form action=\"Connexion.php\" method=\"post\">

				<p>
					<input type=\"text\" name=\"Nom\" style='text-transform:uppercase' />
				</p>

				<p>
				
				Veuillez taper votre mot de passe
				
				</p>

				<p>
					<input type=\"password\" name=\"mdp\"  />
				</p>
				
				<p>
					<input type=\"submit\" value=\"Connexion\" />
				</p>
				</form>

				</center>";
				
				
				include "Base.php";
?>