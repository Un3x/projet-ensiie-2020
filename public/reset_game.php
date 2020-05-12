<?php

use Ingame\IngameRepository;

include '../src/Ingame.php';
include '../src/IngameRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$ingameRepository = new IngameRepository($dbAdaper);
$ingameRepository->reset_game();

header("Location: client.php");

?>