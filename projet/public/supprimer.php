<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$id = $_POST['commentaire'];
	$supprimer = $dbAdapter->prepare("UPDATE Commentaire SET alerte='' WHERE id=?"); //On met à jour l'attribut alerte de Commentaire//
	$supprimer->execute(array($id));

	header('Location: administration.php');
?>