<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$userHydrator = new Model\Hydrator\UserHydrator();
$userRepository = new Model\Repository\UserRepository($dbAdapter, $userHydrator);
$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);

$data["user"] = $userRepository->findUserById($_GET["id"]);
/*$data["games"] = $gameRepository->details($_GET["id"]);
$data["friends"] = $userRepository->friends($_GET["id"]);*/
$data["messages"] = $messageRepository->lastUserMessages($_SESSION["id"], $_GET["id"], 0);
loadView("user", $data);