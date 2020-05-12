<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$userHydrator = new Model\Hydrator\UserHydrator();
$userRepository = new Model\Repository\UserRepository($dbAdapter, $userHydrator);
$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);
$gameHydrator = new Model\Hydrator\GameHydrator();
$gameRepository = new Model\Repository\GameRepository($dbAdapter, $gameHydrator);

$data = [];
$data["users"] = $userRepository->lastUsers();
$data["messages"] = $messageRepository->lastPublicMessages($_SESSION["id"], 0);
$data["games"] = $gameRepository->lastGames();
loadView("home", $data);
