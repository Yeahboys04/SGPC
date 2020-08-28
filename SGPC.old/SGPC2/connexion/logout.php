<!--logout.php-->
<!--Déconnecte la personne, en détruisant la session et redirige sur la page d'accueil-->
<?php
$racine = '../';
require_once '../include/constantes.php';
require_once BDD;
require_once vars;
include_once config;
$db = Database::getInstance();
session_start();
$res = $db->select("select * from user_log where SESSION_ID = '".session_id()."' and START = '".$_SESSION['start']."'");
$autoclose = '0';
if($res['END'] < (new \DateTime())->format('Y-m-d H:i:s')){
  $autoclose = '1';
}
$db->executer("UPDATE user_log set END = now(), AUTOCLOSE = '".$autoclose."' where SESSION_ID = '" . session_id() . "'
and START = '" . $_SESSION['start'] . "'");
session_destroy();
header("Location : $racine$page_accueil");
?>
