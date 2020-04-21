<?php
require_once 'sockets_utils.php';

$msg = "add id://" . $_POST['id'] . "\n" ;
send_to_all_lectors($msg);
?>
