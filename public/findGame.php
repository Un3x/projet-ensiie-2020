<?php

use Ingame\IngameRepository;

include '../src/Ingame.php';
include '../src/IngameRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$game_type = $_POST['mdj'] ?? null;

if($game_type){
    $ingamerepository = new IngameRepository($dbAdaper);
    $ingamerepository->matchmaking($game_type);
}

header('Location: /client.php?retour=5');

?>