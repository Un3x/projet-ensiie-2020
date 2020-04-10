#!/usr/local/bin/php -q
<?php
/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

function socket_create_and_connect($address, $port)
{
    if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
    {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }

    if (( socket_connect($sock, $address, $port)) === false)
    {
        echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
    return $sock;
}

function write_to_socket($sock, $msg)
{
    if (socket_write($sock, $msg, strlen($msg)) === false) {
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
    }
    else echo "Written.";
}

function add_id($sock, $id)
{
    write_to_socket($sock, "add id://" . $id);
}

$ip = $_SERVER['REMOTE_ADDR'];

$address = 'localhost';
$port = 6600;

$sock = socket_create_and_connect($address, $port);
add_id($sock, 2174);
write_to_socket($sock, "play");
socket_close($sock);


?>
