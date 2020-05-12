<?php

include_once '../src/utils/autoloader.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);

$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService(); /* le lien à la BD */

$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, $PersonneHydrator);

 	$config = include '../src/config/config.php';
        $bd_co = new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );

	
	$date = date('y-m-d h:i:s');	
	$PersonneRepository->insert($_POST["mail"],
				    $_POST["nom"],
				    $_POST["prenom"],
				    $_POST["pseudo"],
				    $date,
				    $_POST["anniversaire"],
				    $_POST["mdp"],
				    $_POST["pays"],
				    "0");

	include_once '../src/view/template.php';
	loadView('thanks_signup', $_POST);
?>

