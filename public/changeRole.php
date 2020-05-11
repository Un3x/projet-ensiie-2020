<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$player_role = $_GET['role'] ?? null;

if ($player_role) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $utilisateurRepository->update_roles($player_role);
}

header("Location: client.php");

?>