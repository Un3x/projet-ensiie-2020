<?php

include '../Model/Entity/User.php';
include '../Model/Repository/UserRepository.php';
include '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

if (!(empty ($_POST["username"])) AND !(empty ($_POST["password"]))) {

	$username = $_POST["username"];
	$password = $_POST["password"];

	$nbUser = $userRepository->checkInfos($username,$password);

	if($nbUser == 1) {	// on vérifie que l'on a bien un seul tuple
		session_start();
		$userRepository-> setGlobalVars($username);	// création des variables globales de la session
		header('Location: ../View/home.php');
	}
	else {
		header('Location: ../View/connection.html');
	}

}	
else {	// au moins un des champs n'a pas été rempli

	header('Location: ../View/connection.html');
}


?>