<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;

if ($utilisateurNom) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $utilisateurRepository->create_admin($utilisateurNom);
}

header('Location: /admin.php');

?>