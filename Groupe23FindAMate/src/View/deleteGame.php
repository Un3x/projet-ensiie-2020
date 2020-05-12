<?php


$dbAdaper = (new DbAdaperFactory())->createService();


if (isset($_POST['game_id'])) {
    
    $gameId = $_POST['game_id'];
    $gameRepository = new \src\Model\repository\GameRepository($dbAdaper);
    $gameRepository->delete($gameId);
    header('Location: index.php');
    
}


header('Location: gamelist.php');


?>