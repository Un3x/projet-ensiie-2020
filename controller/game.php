<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$gameHydrator = new Model\Hydrator\GameHydrator();
$userHydrator = new Model\Hydrator\UserHydrator();
$gameRepository = new Model\Repository\GameRepository($dbAdapter, $gameHydrator);
$userGameRepository = new Model\Repository\UserGameRepository($dbAdapter, $gameHydrator, $userHydrator);
$messageHydrator = new Model\Hydrator\MessageHydrator();
$messageRepository = new Model\Repository\MessageRepository($dbAdapter, $messageHydrator);

$data["game"] = $gameRepository->details($_GET["id"]);
$data["users"] = $userGameRepository->lastUsersGame($_GET["id"]);
$data["messages"] = $messageRepository->lastGameMessages($_SESSION["id"], $_GET["id"], 0);
loadView("game", $data);