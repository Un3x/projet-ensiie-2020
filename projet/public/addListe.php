<?php

	session_start();

	include '../src/Liste.php';
	
	include '../src/ListeRepository.php';
	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$pseudo = $_SESSION['username'] ?? null;
	$nom = $_POST['nom_liste'] ?? null;
	if ($pseudo && $nom) {
    	$ListeRepository = new \Liste\ListeRepository($dbAdapter);
    	$ListeRepository->add($pseudo,$nom);
	}

	header('Location: /mylists.php');

?>
