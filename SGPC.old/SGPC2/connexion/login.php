<!--login.php-->
<!--Connecte un utilisateur au site, soit localement ou avec le CAS (Compte Univ Lorraine)-->
<?php
$racine = '../';
require_once '../include/constantes.php';
include_once config;
include_once BDD;
$db = Database::getInstance();
session_start();
if (isset($_POST['login']) && isset($_POST['password'])){//connexion local
  $login = $_POST['login'];
  $_SESSION = array();
  $_SESSION['login'] = $login;

  $_SESSION['start'] = (new \DateTime())->format('Y-m-d H:i:s');
  $_SESSION['maxLength'] = $db->selectData('tableParametres', "where nom = 'session';")->fetch_assoc()['valeur'];
  $statut = $db->verifierConnexionLocale($login, $_POST['password']);//verification login et mot de passe
  if(! $statut){//Erreur
    $_SESSION['value_error'] = "Erreur de connexion : Login ou mot de passe incorrect.";
    header("Location: connexion.php");
    exit();
  }
}else if(isset($_SESSION['phpCAS'])){//connexion par CAS
  $login = $_SESSION['phpCAS']['user'];
  $_SESSION = array();
  $_SESSION['login'] = $login;

  $_SESSION['start'] = (new \DateTime())->format('Y-m-d H:i:s');
  $_SESSION['maxLength'] = $db->selectData('tableParametres', "where nom = 'session';")->fetch_assoc()['valeur'];
  $statut = $db->userExiste($login);
  if($statut == false){
    $db->ajouterUtilisateur($login);
    $statut = $db->referenceValeur('tablestatutUser','C');
//Envoie de mail pour signaler un nouvel utilisateur
	ob_start();
	echo "Un nouvel utilisateur s'est connecté. Voici son identifiant : ";
	echo $_SESSION['login'];
	$m = ob_get_contents();

	$destinataire = "mickael.dardinier54300@gmail.com";//changer le mail par la suite
	$header = "Content-Type: text/html; charset=\"iso-8859-1\"";

	$sujet = "Nouvel utilisateur sur ZRR";
	$mail =  mail($destinataire, $sujet, $m, $header);
	if($mail){
	  echo 'mail envoyé';
	}else{
	  echo 'erreur mail';
	}
  }
}
$_SESSION['statut'] = $statut;
require('log.php');
header("Location: $racine$page_accueil");
?>
