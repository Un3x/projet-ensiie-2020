<?php

require_once 'sockets_utils.php';

$msg = "play\n";
send_to_all_lectors($msg);
?>
