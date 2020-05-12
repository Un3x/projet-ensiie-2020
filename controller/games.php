<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$gameHydrator = new Model\Hydrator\GameHydrator();
$gameRepository = new Model\Repository\GameRepository($dbAdapter, $gameHydrator);

$data = $gameRepository->lastGamesDetailed();
loadView("games", $data);