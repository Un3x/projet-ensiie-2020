<?php

use Utilisateur\UtilisateurRepository;

include '../src/Utilisateur.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$game_type = $_POST['mdj'] ?? null;

if($game_type){
    $utilisateurRepository = new UtilisateurRepository($dbAdaper);
    $utilisateurRepository->matchmaking($game_type);
}

header('Location: /client.php?retour=5');

?>