<?php

include_once '../src/utils/autoloader.php';

error_reporting(E_ALL);
ini_set('display_errors', 1);
use \Rediite\Model\Entity\Abonnement;
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService(); /* le lien à la BD */

$AbonnementRepository = new \Rediite\Model\Repository\AbonnementRepository($dbAdapter);

 	$config = include '../src/config/config.php';
        $bd_co = new \PDO(
            sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
            $config['db']['user'],
            $config['db']['password']
        );

?>