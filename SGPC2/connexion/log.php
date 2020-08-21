<!--log.php-->
<!--Inscrit la connexion de l'utilisateur dans la table des connexions-->
<?php
$db = Database::getInstance();
$ua = $_SERVER['HTTP_USER_AGENT'];
$ua = explode(' ', $ua);
$count = count($ua);
for ($i = 0; $i < $count; $i++){
  if (strncmp($ua[$i], '(Windows', 8) == 0){
    $os = "Windows ";
    $i += 2;
    switch ($ua[$i]){
      case '6.1;':
      $os .= "7";
      break;
      case '6.2;':
      $os .= "8";
      break;
      case '6.3;':
      $os .= "8.1";
      break;
      default:
      $os .= "";
      break;
    }
  }
  if (strncmp($ua[$i], 'Trident', 7) == 0){
    $brow = "Internet Explorer ";
    $i += 1;
    $b = explode(':', $ua[$i]);
    $brow .= trim($b[1], ")");
  }
  if (strncmp($ua[$i], 'Firefox', 7) == 0){
    $b = explode('/', $ua[$i]);
    $brow = $b[0].' '.$b[1];
  }
  if (strncmp($ua[$i], 'Chrome', 6) == 0){
    $b = explode('/', $ua[$i]);
    $brow = $b[0].' '.$b[1];
  }
}
if (isset($os) && isset($brow))
$useragent = $os.' '.$brow;
else
$useragent = substr($_SERVER['HTTP_USER_AGENT'],0,254);
$sql = "INSERT INTO user_log (LOGIN, START, SESSION_ID, REMOTE_ADDR, USER_AGENT, AUTOCLOSE, END) values (
  '" . $_SESSION['login'] . "',
  '" . $_SESSION['start'] . "',
  '" . session_id() . "',
  '" . $_SERVER['REMOTE_ADDR'] . "',
  '" . $useragent . "',
  '1',
  '" . $_SESSION['start'] . "' + interval " . $_SESSION['maxLength'] . " minute
)
;";
$db->executer($sql);
?>
