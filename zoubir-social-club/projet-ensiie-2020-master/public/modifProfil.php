<?php
include_once '../src/utils/autoloader.php';
// create the database connection
$dbfactory = new \Rediite\Model\Factory\DbAdapterFactory();
$dbAdapter = $dbfactory->createService();
$PersonneHydrator = new \Rediite\Model\Hydrator\PersonneHydrator();
$PersonneRepository = new \Rediite\Model\Repository\PersonneRepository($dbAdapter, $PersonneHydrator);

$data=[];
include_once '../src/view/template.php';
loadView('modifProfil', $data);

?>