<?php
	
	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$personne = $_POST['personne'];

	$personne = $_POST['personne'];
	$mute = $dbAdapter->prepare('UPDATE Utilisateur SET banni=false WHERE pseudo=?');//Puis on banni l'utilisateur 
	$mute->execute(array($personne));

	header('Location: administration.php');

?>