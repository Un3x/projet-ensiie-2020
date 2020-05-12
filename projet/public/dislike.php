<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$pseudo = $_SESSION['username'];
	$liste = $_POST['liste'];
	$personne = $_POST['personne'];

	$liker = $dbAdapter->prepare('DELETE FROM Liker WHERE liste= ? AND pseudo = ?');
	$liker->execute(array($liste,$pseudo));

	$liste_likes = $dbAdapter->prepare('UPDATE Liste SET likes=likes-1 WHERE id = ?');
	$liste_likes->execute(array($liste));
	
	header("Location: ".$_SERVER['HTTP_REFERER']);

?>