<?php


$dbAdaper = (new DbAdaperFactory())->createService();


if (isset($_POST['game_id']) & isset($_POST['user_id'])) {
    $gameId = $_POST['game_id'];
    $gameName= $_POST['game_name'];
    $pseudo = $_POST['user_id'];
    $gameRepository = new \src\Model\repository\GameRepository($dbAdaper);
    $gameRepository->addAcquired($gameId,$gameName,$pseudo);
    header('Location: index.php');   
}

header('Location: gamelist.php');

?>