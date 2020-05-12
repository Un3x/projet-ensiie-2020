<?php

$socket->prepareLoggingOffInfo();
if (!$socket->sendData())
	$this->socket->printError();

// Unset all of the session variables
$_SESSION = array();
 
// Destroy the session.
session_destroy();
 
// Redirect to login page
header('Location: /'); 
exit;

?>
