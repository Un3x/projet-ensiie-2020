<?php
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Lectors/Lector.php';
require_once 'Lectors/LectorRepository.php';
require_once 'Factory/DbAdaperFactory.php';

/** 
 * @requires an IP adress
 * @assigns if needed, changes the given ip adress to work with lektord
 * @ensures return the correct domain to use for the socket (AF_INET or AF_INET6)
 */
function correctIPDomain(&$ip)
{
    if ( (filter_var($ip, FILTER_VALIDATE_IP,FILTER_FLAG_IPV6) === true) || $ip == "::1" )
    {
        echo "Using IPV6 addresses\n";
        return AF_INET6;
    }
    elseif ( filter_var($ip, FILTER_VALIDATE_IP, FILTER_FLAG_IPV4) === true || $ip == "127.0.0.1" )
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
    else 
    {
        echo "Bruh I don't know anymore. ";
        echo "Can't decide between IPV4 and IPV6 adresses";
        echo "Let's try IPV4\n";
        return AF_INET;
    }
    return -1;
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
        return 1;
    }
    return 0;
}

function send_to_one_lector($msg, $address, $port, $domain)
{
    if ( ($sock = socket_create($domain, SOCK_STREAM, SOL_TCP)) === false )
    {
        echo "socket_create() failed: reason: " . socket_strerror(socket_last_error()) . "\n";
        return(1);
    }

    socket_set_option($sock, SOL_SOCKET, SO_RCVTIMEO, array('sec'=>4, 'usec'=>0));
    socket_set_option($sock, SOL_SOCKET, SO_SNDTIMEO, array('sec'=>4, 'usec'=>0));
    if ( ( socket_connect($sock, $address, $port)) === false )
    {
        echo "socket_connect() failed: reason: " . socket_strerror(socket_last_error()) . " : is lektord active on this lector ?\n";
        return(2);
    }

    echo "Created socket to connect to lektord on IP " . $address . " at port " . $port . "\n";
    if ( socket_write_message($sock, $msg) === 1 )
    {
        echo "Writing to socket " . $i . " failed.\n";
        return(3);
    }
    echo "Written to lektord on IP " . $address . " at port " . $port . "\n";
    socket_close($sock);
    return(0);
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
    /*
    $socket_timeout = 1;
    ini_set("default_socket_timeout",$socket_timeout);
     */
    foreach($lectors as $lector){
        error_log("Starting sending to lektor number $i");
        $address = "";
        $port = 0;
        $domain = "";

        $address = $lector->getIP();
        $port = $lector->getPort();
        $domain = correctIPDomain($address);
        send_to_one_lector($msg, $address, $port, $domain);
        error_log("Finished sending to lektor number $i");
        $i = $i+1;
    }

    /*
    foreach($lectors as $lector){
        $pids[$i] = pcntl_fork();

        if ( $pids[$i] == -1 ) // On error
        {
            error_log("Error forking one lector\n");
            exit(1);
        }

        elseif ( !$pids[$i] ) // Child
        {
            error_log("Starting sending to lektor number $i");
            $address = "";
            $port = 0;
            $domain = "";

            $address = $lector->getIP();
            $port = $lector->getPort();
            $domain = correctIPDomain($address);
            send_to_one_lector($msg, $address, $port, $domain);
            error_log("Finished sending to lektor number $i");
            exit(0);
        }
        $i = $i+1;
    }

    $ret = false;
    for  ( $j=0; $j<$i; $j++ )
    {
        error_log("FORK J : $j");
        pcntl_waitpid($pids[$j], $status, WNOHANG);
        if ( pcntl_wifexited($status) !== true )
            echo "Unexpected error for lector $j\n";
        else
        {
            if ( pcntl_wexitstatus($status) === 0 )
            {
                error_log("Lector $j finished OK\n");
                echo "Lector $j finished OK\n";
                $ret = true;
            }
            else
                error_log("Lector $j exited with code error " . pcntl_wexitstatus($status) . "\n");
                echo "Lector $j exited with code error " . pcntl_wexitstatus($status) . "\n";
        }
    }
    return $ret;
     */
}
?>
