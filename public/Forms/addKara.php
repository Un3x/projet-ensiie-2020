<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
require_once 'Factory/DbAdaperFactory.php';
require_once 'Lektor_interface/sockets_utils.php';
require_once 'Lektor_interface/test.php';

if (isset($_SESSION['id']))
{
    if ( !($_SESSION['rights'] === 1 || $_SESSION['rights'] === 2 ) ) 
        {
        include_once "ddosPrevention.php";
        if ($_SESSION['sleepState']==1){
            echo "Bro just stop\n";
            exit();
        }
    }

    $id = htmlspecialchars($_POST['id']);

    $dbAdapter = (new DbAdaperFactory())->createService();
    echo "Adding kara n°" . $id . "...\n";
    $req =
        'INSERT INTO "queue" (id, added_by)
         VALUES(:id, :adder);';
    $addition = $dbAdapter->prepare($req);
    $addition->bindParam('id', $id, \PDO::PARAM_INT);
    $addition->bindParam('adder', $_SESSION['id'], \PDO::PARAM_INT);
    $addition->execute();


    $msg = "add id://" . $id . "\n" ;
    error_log("SOCKETS : Starting sending to all lectors");
    send_to_all_lectors($msg);
    /*
    if ( $success === true )
        error_log("SOCKETS : Finished sending to all lectors successfully (at least successfull for one)");
    else
        error_log("SOCKETS : Finished sending to all lectors : all failed");
     */
}

else
{
    echo "I'm gonna pay you $100 to fuck off.";
}
?>
