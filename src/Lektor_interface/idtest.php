<?php
#!/usr/local/bin/php -q
error_reporting(E_ALL);

/* Allow the script to hang around waiting for connections. */
set_time_limit(0);

/* Turn on implicit output flushing so we see what we're getting
 * as it comes in. */
ob_implicit_flush();

$address = 'localhost';
$port = 6600;

if (($sock = socket_create(AF_INET, SOCK_STREAM, SOL_TCP)) === false)
{
    echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

if (( socket_connect($sock, $address, $port)) === false)
{
    echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
}

/*
if (socket_bind($sock, $address, $port) === false) {
    echo "socket_bind() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}
 */

$msg = "add id://" . $_POST['id'] . "\n" ;
if (socket_write($sock, $msg, strlen($msg)) === false) {
    echo "socket_write() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
}

socket_close($sock);
?>
