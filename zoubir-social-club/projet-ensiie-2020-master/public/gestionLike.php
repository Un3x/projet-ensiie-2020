<?php

include_once '../src/utils/autoloader.php';
include_once '../src/view/message_view.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

use \Rediite\Model\Entity\Abonnement;
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService(); /* le lien à la BD */

$LikeRepository    = new \Rediite\Model\Repository\LikerRepository($dbAdapter);

$MessageHydrator = new \Rediite\Model\Hydrator\MessageHydrator();
$MessageRepository = new \Rediite\Model\Repository\MessageRepository($dbAdapter,
                                                                     $MessageHydrator);


    
if (isset($_POST['unlike']))
{
    $id_mess = $_POST['unlike'];
    $n_pers = $_SESSION['n_pers'];
    $LikeRepository->unlike($id_mess,$n_pers);
    
    include_once '../src/view/template.php';
    loadView('search',[]);
    header("Location:search.php");
}
if (isset($_POST['like']))
{
    $n_mess = $_POST['like'];
    $n_pers = $_SESSION['n_pers']; 
    $LikeRepository->insertLike($n_pers,$n_mess);
    $LikeRepository->addOneLike($n_mess);
    include_once '../src/view/template.php';
    loadView('search',[]);
    header("Location:search.php");
}


?>