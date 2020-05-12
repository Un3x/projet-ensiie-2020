<?php

	include '../src/User.php';
	include '../src/UserRepository.php';
	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$pseudo = $_POST['username'] ?? null;
	$nom = $_POST['lastname'] ?? null;
	$prenom = $_POST['firstname'] ?? null;
	$mdp = $_POST['password'] ?? null;
	$mail = $_POST['mail'] ?? null;

	if ($username && $lastname && $firstname && $password && $email) {
   		$UserRepository = new \User\UserRepository($dbAdapter);
    	$UserRepository->insert($username,$lastname,$firstname,$password,$email,'false','false');
	}

	header('location: /signIn.php');

?>