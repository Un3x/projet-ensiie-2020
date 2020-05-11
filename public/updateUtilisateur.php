<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$utilisateurNom = $_POST['nom_utilisateur'] ?? null;
$utilisateurNewMdp = $_POST['mdp_utilisateur'] ?? null;
$utilisateurMail = $_POST['mail_utilisateur'] ?? null;

$utilisateurRepository = new UtilisateurRepository($dbAdaper);
if($utilisateurNewMdp){
    $utilisateurRepository->update_password($utilisateurNewMdp);
}
if($utilisateurNom){
    $utilisateurRepository->update_username($utilisateurNom);
}
if($utilisateurMail){
    $utilisateurRepository->update_mail($utilisateurMail);
}

header('Location: /client.php');

?>