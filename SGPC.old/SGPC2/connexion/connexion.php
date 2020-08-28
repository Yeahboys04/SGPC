<!--connexion.php-->
<!--Partie qui permet de visualiser le formulaire de connexion du site-->
<?php
session_start();
?>
<!DOCTYPE html>
<html lang="fr">
<head>
	<meta charset="utf-8" />
	<title>Connexion Georessources</title>
	<link rel="stylesheet"  href="../css/style_connexion.css">
	<link href="../css/google_style.css" rel="stylesheet">
	<script type="text/javascript" src="../js/script.js"></script>
</head>
<body>
	<?php
	//Message erreur
	if(isset($_SESSION['value_error'])){ ?>
		<div id="bloc_error">
			<div id="error_top">
				<img src="../img/logo_error.png"/>
				<p>Une erreur est survenue</p>
			</div>
			<p id="txt_error"> <?php echo $_SESSION['value_error'];
			unset($_SESSION['value_error']);
			?></p>
		</div>
	<?php } ?>
	<div id="bloc_connexion">
		<p id='menu_co'>Connexion</p>
		<div id="bloc_onglet_co">
			<div id="ensemble_big_button">
				<a href="../index.php?force_authentification=y"><div class="bloc_big_button" id="ul_button">
					<div id="left_logo"><img src="../img/logo_ul.png" width="55"/></div>
					<div id="text_big_button">Connexion via votre compte UL</div>
				</div></a>
			</div>
			<p id="bloc_entete_co">
				<br/>
				Vous pouvez également vous connecter localement, et accéder à votre compte.
			</p>
			<div id="sep"></div>
			<!-- Formulaire de connexion local -->
			<form method="post" action="login.php" name="form_co">
				<div id="bloc_input_co">
					<p>Login *</p>
					<input type="text" name="login" id="login_co" onKeyPress="if (event.keyCode == 13) focus_send()"
					placeholder="Entrez votre login">
				</div>
				<div id="sep"></div>
				<div id="bloc_input_co">
					<p>Mot de passe *</p>
					<input type="password" name="password" id="mdp_co" onKeyPress="if (event.keyCode == 13) focus_send()"
					placeholder="Entrez votre mot de passe">
				</div>
				<div id="sep"></div>
			</form>
			<div id="bloc_link_co">
				<a href="#">
					<div class="bouton_co" id="green_button" onclick="focus_send()">Connexion</div>
				</a>
			</div>
		</div>
	</div>
</body>
</html>
