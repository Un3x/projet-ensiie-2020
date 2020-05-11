<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['utilisateur_id'] ?? null;
if ($userId) {
    $userRepository = new UtilisateurRepository($dbAdaper);
    $userRepository->delete($userId);
}

header('Location: /');

?>