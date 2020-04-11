<?php
include_once 'sockets_utils.php';
include_once 'lektord_communication_setup.php';

$msg = "play\n";
socket_write_message($sock, $msg);

?>
