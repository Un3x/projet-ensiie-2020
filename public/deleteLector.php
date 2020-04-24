<?php

use Lector\LectorRepository;

include '../src/Lector.php';
include '../src/LectorRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$lectorId = $_POST['lector_id'] ?? null;
if ($lectorId) {
    $lectorRepository = new LectorRepository($dbAdaper);
    $lectorRepository->delete($lectorId);
}

header('Location: /');

?>
