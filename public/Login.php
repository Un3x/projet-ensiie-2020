<?php

use Utilisateur\UtilisateurRepository;
use PplOnline\PplOnlinerepository;

include '../src/Utilisateur.php';
include '../src/PplOnline.php';
include '../src/UtilisateurRepository.php';
include '../src/PplOnlineRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;
$utilisateurMdp = $_POST['mdp_utilisateur'] ?? null;
if ($utilisateurNom && $utilisateurMdp) {
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $pplonlineRepository = new PplOnlineRepository($dbAdaper);
    $success = $utilisateurRepository->login($utilisateurNom, $utilisateurMdp);
    if($success == 1) $pplonlineRepository->justConnected();
}else{
    echo("Error username or password emtpy");
} 

?>