<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$id = $_POST['commentaire'];
	$supprimer = $dbAdapter->prepare('DELETE FROM Commentaire WHERE id=?'); //On supprime le commentaire
	$supprimer->execute(array($id));

	header("Location: ".$_SERVER['HTTP_REFERER']);

?>