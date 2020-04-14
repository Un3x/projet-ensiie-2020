<?php
include_once 'sockets_utils.php';
include_once 'lektord_communication_setup.php';

$msg = "add id://" . $_POST['id'] . "\n" ;
socket_write_message($sock, $msg);
?>
