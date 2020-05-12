<?php

use Aliment\AlimentRepository;

include '../src/Aliment.php';
include '../src/AlimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$alimentId = $_POST['aliment_id'] ?? null;
if ($alimentId) {
    $alimentRepository = new AlimentRepository($dbAdaper);
    $alimentRepository->delete($alimentId);
}

header('Location: /');

?>