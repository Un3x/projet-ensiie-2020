<?php
session_start();
require_once 'sockets_utils.php';

/*
if (isset($_SESSION['id']))
{
 */
    echo "Adding kara n°" . $_POST['id'] . "\n";
    $msg = "add id://" . $_POST['id'] . "\n" ;
    send_to_all_lectors($msg);
    /*
}

else
{
    echo "I'm gonna pay you $100 to fuck off.";
}
     */
?>
