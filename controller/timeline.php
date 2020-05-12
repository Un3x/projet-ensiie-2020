<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$userHydrator = new Model\Hydrator\UserHydrator();
$userRepository = new Model\Repository\UserRepository($dbAdapter, $userHydrator);
$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);
$gameHydrator = new Model\Hydrator\GameHydrator();
$userHydrator = new Model\Hydrator\UserHydrator();
$userGameRepository = new Model\Repository\UserGameRepository($dbAdapter, $gameHydrator, $userHydrator);

$data = [];
$data["users"] = $userRepository->following($_SESSION["id"]);
$data["messages"] = $messageRepository->lastFollowedMessages($_SESSION["id"], 0);
$data["games"] = $userGameRepository->getUserGames($_SESSION["id"]);
loadView("timeline", $data);