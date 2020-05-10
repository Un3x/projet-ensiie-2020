<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
require_once 'Factory/DbAdaperFactory.php';
require_once 'Lektor_interface/sockets_utils.php';

if (isset($_SESSION['id']) && $_SESSION['rights'] >= 1)
{
    $dbAdapter = (new DbAdaperFactory())->createService();
    echo "Deleting kara at position " . $_POST['id'] . "...\n";
    $req =
        'DELETE FROM "queue"
         WHERE id=:id;';
    $addition = $dbAdapter->prepare($req);
    $addition->bindParam('id', $_POST['id']);
    $addition->execute();


    $msg = "deleteid " . $_POST['id'] . "\n" ;
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
