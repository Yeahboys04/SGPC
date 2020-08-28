<?php date_default_timezone_set("Europe/Paris");

	session_start();
		$_SESSION['id'] = 0;
		$_SESSION['Admin'] = 0;
		session_destroy();
		echo '
		<script> alert("Vous êtes bien déconnecté");  
	         window.location.replace("Accueil.php");
		</script>
         ';










?>