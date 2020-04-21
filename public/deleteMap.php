<?php

use Map\MapRepository;

include '../src/Map.php';
include '../src/MapRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$mapId = $_POST['mapId'] ?? null;
if ($mapId) {
    $mapRepository = new MapRepository($dbAdaper);
    $mapRepository->delete($mapId);
}

header('Location: /');

?>