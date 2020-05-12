<?php

use Recette\RecetteRepository;

include '../src/Recette.php';
include '../src/RecetteRepository.php';
include '../src/Factory/DbAdaperFactory2.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['recette_id'] ?? null;
if ($userId) {
    $userRepository = new RecetteRepository($dbAdaper);
    $userRepository->delete($userId);
}

header('Location: /');

?>