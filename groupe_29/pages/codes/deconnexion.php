<?php
session_start();
$_SESSION = array();
session_destroy();
header('Location: 1_Page_1.php');
exit();
?>