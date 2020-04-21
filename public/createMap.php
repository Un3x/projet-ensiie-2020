<?php

use Map\MapRepository;

include '../src/Map.php';
include '../src/MapRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$mapMeteo = $_POST['mapMeteo'] ?? null;
$mapTerrain = $_POST['mapTerrain'] ?? null;
$mapMdj = $_POST['mapMdj'] ?? null;
if ($mapMeteo && $mapTerrain && $mapMdj) {
    $mapRepository = new MapRepository($dbAdaper);
    $mapRepository->create($mapMeteo, $mapTerrain, $mapMdj);
}

header('Location: /');

?>