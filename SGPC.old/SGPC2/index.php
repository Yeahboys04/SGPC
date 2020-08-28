<!--index.php-->
<?php
session_start();
require_once("./include/cas.inc.php");

if($login){
  header('Location:connexion/login.php');
}
?>
