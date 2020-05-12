<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$pseudo = $_SESSION['username'];
	$liste = $_GET['liste'];
	$personne = $_GET['personne'];
	$_SESSION['ami'] = $personne;

	$liker = $dbAdapter->prepare('INSERT INTO Liker (liste,pseudo) VALUES (?,?)');
	$liker->execute(array($liste,$pseudo));

	$liste_likes = $dbAdapter->prepare('UPDATE Liste SET likes=likes+1 WHERE id = ?');
	$liste_likes->execute(array($liste));
	
	header("Location: modifier-profil.php"."?personne=".$_SESSION['ami']);

?>