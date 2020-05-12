<?php
include_once '../src/utils/autoloader.php';
// create the database connection
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();

$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, 
																	   $PersonneHydrator);

$MessageHydrator = new \Rediite\Model\Hydrator\MessageHydrator();
$MessageRepository = new \Rediite\Model\Repository\MessageRepository($dbAdapter, 
																	 $MessageHydrator);
$aboMessage = $MessageRepository->selectMessageByAbo($_SESSION['n_pers']);
include_once '../src/view/template.php';
loadView('newsfeed', $aboMessage);
//printMessageByWriter($_SESSION['n_pers']);
?>