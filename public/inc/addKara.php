<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
require_once 'Factory/DbAdaperFactory.php';
require_once 'Lektor_interface/sockets_utils.php';

/*
if (isset($_SESSION['id']))
{
 */
    $dbAdapter = (new DbAdaperFactory())->createService();
    echo "Adding kara n°" . $_POST['id'] . "...\n";
    $req =
        'INSERT INTO "queue" (position, id, added_by)
         VALUES(4, :id, :adder);';  // <-- FIXME
    $addition = $dbAdapter->prepare($req);
    $addition->bindParam('id', $_POST['id']);
    //$addition->bindParam('adder', $_SESSION['username']);
    $bruh = 42;
    $addition->bindParam('adder', $bruh);  // <--- FIXME : delete this and replace with above line when checking if session id is set
    $addition->execute();


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
