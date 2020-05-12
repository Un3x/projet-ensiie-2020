<?php

include_once '../src/utils/autoloader.php';
include_once '../src/view/message_view.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use \Rediite\Model\Entity\Abonnement;
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService(); /* le lien à la BD */

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, 
                                                                       $PersonneHydrator);

$MessageHydrator = new \Rediite\Model\Hydrator\MessageHydrator();
$MessageRepository = new \Rediite\Model\Repository\MessageRepository($dbAdapter,
                                                                     $MessageHydrator);


    
    if (isset($_POST['message_delete']))
    {
        $id_mess = $_POST['message_delete'];
        $MessageRepository->deleteMessageById($id_mess);
        include_once '../src/view/template.php';
        loadView('search',[]);
    }
    

?>