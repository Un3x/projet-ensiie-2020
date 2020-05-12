<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$raison = $_POST['signalement']??null;
	$id_com = $_POST['commentaire'];

	if ($raison){
		$commentaire = $dbAdapter->prepare('UPDATE Commentaire SET alerte=? WHERE id=?');
		$commentaire->execute(array($raison,$id_com));
	}

	header('Location:'.$_SERVER['HTTP_REFERER']);
?>