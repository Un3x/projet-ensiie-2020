<?php
include_once 'sockets_utils.php';

error_reporting(E_ALL);
ob_implicit_flush();


if ( $GLOBALS["lektordIP"] == NULL )
{
    echo "Getting lektord IP address\n";
    $address = $_SERVER['REMOTE_ADDR'];
    $GLOBALS["lektordIP"] = $address;
}
else echo "Using stored value for lektord IP address\n";

if ( $GLOBALS["lektordPort"] == NULL )
{
    $port = 6600; // Default port for lektord
    $GLOBALS["lektordPort"] = $port;
}

if ( $GLOBALS["lektordIPDomain"] == NULL )
{
    $domain = correctIPDomain($address);
    $GLOBALS["lektordIPDomain"] = $domain;
}

if ( $GLOBALS["lektordSocket"] == NULL )
{
    echo "Creating socket to connect to lektord\n";
    $sock = socket_create_and_connect($address, $port, $domain);
    $GLOBALS["lektordSocket"] = $sock;
}
else echo "Using created socket\n";
?>
