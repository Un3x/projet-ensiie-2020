<?php
/** 
 * @requires an IP adress
 * @assigns if needed, changes the given ip adress to work with lektord
 * @ensures return the correct domain to use for the socket (AF_INET or AF_INET6)
 */
function correctIPDomain(&$ip)
{
    if ( filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4) === true || $ip == "127.0.0.1" )
    {
        echo "Using IPV4 addresses\n";
        return AF_INET;
    }
    else if ( (filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6) === true) || $ip == "::1" )
    {
        /*
        if ($ip == "::1")
        {
            echo "Saw localhost in IPV6 format. Forcing localhost in IPV4 format for lektord to work\n";
            $ip = "127.0.0.1";
            return = AF_INET;
        }
        else
        {
         */
        echo "Using IPV6 addresses\n";
        return AF_INET6;
    /*
        }
    */
    }
    else 
    {
        echo "Can't decide between IPV4 and IPV6 adresses\n";
    }
}

/**
 * @requires the IP address, the port and the protocol
 * @assigns nothing
 * @ensures equivalent to socket_create() + socket_connect() with error warning
 */
function socket_create_and_connect($address, $port, $domain)
{
    if ( ($sock = socket_create($domain, SOCK_STREAM, SOL_TCP)) === false )
    {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }

    if ( ( socket_connect($sock, $address, $port)) === false )
    {
        echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
    }
    return $sock;
}

/**
 * @requires a socket and a message
 * @assigns nothing
 * @ensures equivalent to socket_write with error warning
 */
function socket_write_message($sock, $msg)
{
    if ( socket_write($sock, $msg, strlen($msg)) === false ) {
        echo "socket_write() failed: reason: " . socket_strerror(socket_last_error($sock)) . "\n";
    }
}
?>
