<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;
$utilisateurMdp = $_POST['mdp_utilisateur'] ?? null;
if ($utilisateurNom && $utilisateurMdp) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $utilisateurRepository->login($utilisateurNom, $utilisateurMdp);
}else{
    echo("Error username or password emtpy");
}

?>