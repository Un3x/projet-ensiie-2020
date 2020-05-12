<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);

$messageRepository->postMessage($_SESSION["id"], $_POST["content"], $_POST["visibility"], "post");
header("Location: /".$_GET["page"]);
die();
