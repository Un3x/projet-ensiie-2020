<?php

include_once '../src/Utils/autoloader.php';
include_once '../src/View/template.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$gameRepository = new \src\Model\repository\GameRepository($dbAdaper);

loadView('deleteGame',[]);
?>