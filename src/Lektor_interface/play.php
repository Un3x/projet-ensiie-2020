<?php
include_once 'sockets_utils.php';
include_once 'lektord_communication_setup.php';

foreach($socks as $sock){
    echo "Writing to one socket\n";
    socket_write_message($sock, "play\n");
    socket_close($sock);
}

?>
