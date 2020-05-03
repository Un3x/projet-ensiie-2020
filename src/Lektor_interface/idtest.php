<?php
session_start();
require_once 'sockets_utils.php';

/*
if (isset($_SESSION['id']))
{
 */
    echo "Adding kara n°" . $_POST['id'] . "\n";
    $msg = "add id://" . $_POST['id'] . "\n" ;
    error_log("SOCKETS : Starting sending to all lectors");
    send_to_all_lectors($msg);
    error_log("SOCKETS : Finished sending to all lectors");
    /*
}

else
{
    echo "I'm gonna pay you $100 to fuck off.";
}
     */
?>
