<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);

if($_SESSION["role"] == "admin")
$messageRepository->deleteMessage($_GET["id"]);
header("Location: /".$_GET["page"]);
die();
