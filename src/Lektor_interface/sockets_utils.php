<?php
require_once '../src/Lector.php';
require_once '../src/LectorRepository.php';
require_once '../src/Factory/DbAdaperFactory.php';

/** 
 * @requires an IP adress
 * @assigns if needed, changes the given ip adress to work with lektord
 * @ensures return the correct domain to use for the socket (AF_INET or AF_INET6)
 */
function correctIPDomain(&$ip)
{
    if ( filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV4) === true || $ip == "127.0.0.1" )
    {
        if ($ip == "127.0.0.1")
        {
            echo "Saw localhost in IPV4 format. Forcing localhost in IPV6 format to be compatible with lektord.\n";
            $ip = "::1";
            return AF_INET6;
        }
        else
        {
        echo "Using IPV4 addresses\n";
        return AF_INET;
        }
    }
    else if ( (filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6) === true) | $ip == "::1" )
    {
        echo "Using IPV6 addresses\n";
        return AF_INET6;
    }
    else 
    {
        echo "Can't decide between IPV4 and IPV6 adresses\n";
        exit(1);
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
        exit(1);
    }

    if ( ( socket_connect($sock, $address, $port)) === false )
    {
        echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . " : is lektord active on this lector ?\n";
        exit(2);
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
        exit(1);
    }
    exit(0);
}

/**
 * @requires a string
 * @assigns still don't know what exactly I'm supposed to put in this
 * @ensures send $msg to all lectors registered in the corresponding sql table
 */
function send_to_all_lectors($msg)
{
    $dbAdaper = (new DbAdaperFactory())->createService();
    $lectorRepository = new \Lector\LectorRepository($dbAdaper);
    $lectors = $lectorRepository->fetchAll();
    $pids = array();
    $i = 0;
    $socket_timeout = 5;
    ini_set("default_socket_timeout",$socket_timeout);

    foreach($lectors as $lector){
        $pids[$i] = pcntl_fork();

        if ( $pids[$i] == -1 ) // On error
        {
            echo "Error forking one lector\n";
            exit(1);
        }

        elseif ( $pids[$i] ) // Child
        {
            $address = "";
            $port = 0;
            $domain = "";

            $address = $lector->getIP();
            $port = $lector->getPort();
            if ( !$domain = correctIPDomain($address) )
            {
                echo "Couldn't determine the IP domain : IP adress is probably incorrect\n";
                exit(4);
            }

            $sock = socket_create_and_connect($address, $port, $domain);
            if ( $sock == 1 )
            {
                echo "Couldn't create socket " . $i . "\n";
                exit(1);
            }
            if ( $sock == 2 )
            {
                echo "Couldn't connect to socket " . $i . " : timeout after " . $socket_timeout . " seconds.\n";
                exit(2);
            }

            echo "Created socket to connect to lektord on IP " . $address . " at port " . $port . "\n";
            if ( !socket_write_message($sock, $msg) )
            {
                echo "Writing to socket " . $i . " failed.\n";
                exit(3);
            }
            socket_close($sock);
            echo "Written to lektord on IP " . $address . " at port " . $port . "\n";
            exit(0);
        }

        $i = $i+1;
    }

    for  ( $j=0; $j<$i; $j++ )
    {
        pcntl_waitpid($pids[$j], $status);
        if ( $status != 0 )
            echo "Lector " . $j . " exited with code error " . $status . "\n";
        else
            echo "OK\n";
    }
    echo "Job over for all lectors";
}
?>
