<?php

function pers_echo($i)
{
    return($i);
}

function test()
{
    $pids = array();
    for ( $i=0; $i<3; $i++ )
    {
        error_log("Starting $i");
        $pids[$i] = pcntl_fork();

        if ( $pids[$i] == -1 ) // On error
        {
            echo "Error forking one lector\n";
            return(1);
        }

        elseif ( !$pids[$i] ) // Child
        {
            sleep($i);
            error_log("BLABLA $i\n");
            exit($i);
        }
    }
    return 3;
}

?>
