<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;
$utilisateurMdp = $_POST['mdp_utilisateur'] ?? null;
$utilisateurMail = $_POST['mail_utilisateur'] ?? null;

if ($utilisateurNom && $utilisateurMdp && $utilisateurMail) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $utilisateurRepository->create($utilisateurNom, $utilisateurMdp, $utilisateurMail);
}else{
    echo("Error username, password or mail empty");
}

//header("Location: /");

?>