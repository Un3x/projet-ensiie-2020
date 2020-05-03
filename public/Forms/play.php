<?php
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Lektor_interface/sockets_utils.php';

$msg = "play\n";
send_to_all_lectors($msg);
?>
