<?php 
session_start();

// Suppression des variables de session et de la session
$_SESSION = array();
session_destroy();

// Suppression des cookies de connexion automatique
setcookie('adresse_mail', '');
setcookie('pass', '');
header("Status: 301 Moved Permanently", false, 301);
header('Location: ../index.php');
?>
