<?php

use Utilisateur\UtilisateurRepository;
use PplOnline\PplOnlineRepository;

include '../src/PplOnline.php';
include '../src/Utilisateur.php';
include '../src/PplOnlineRepository.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;
$utilisateurMdp = $_POST['mdp_utilisateur'] ?? null;
$utilisateurMail = $_POST['mail_utilisateur'] ?? null;

if ($utilisateurNom && $utilisateurMdp &&  $utilisateurMail) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $pplonlineRepository = new PplOnlineRepository($dbAdaper);
    $utilisateurRepository->create($utilisateurNom, $utilisateurMdp, $utilisateurMail);
    $success = $utilisateurRepository->login($utilisateurNom, $utilisateurMdp);
    if($success == 1) $pplonlineRepository->justConnected();
}

?>