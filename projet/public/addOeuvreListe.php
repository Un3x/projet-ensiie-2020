<?php

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$oeuvre = $_GET['nom_oeuvre'] ?? null;
	$id_liste = $_GET['id_liste'] ?? null;
	$user = $_SESSION['username'] ?? null;

	if (!$oeuvre||!$id_liste){
		header('Location:'.$_SERVER['HTTP_REFERER']);
		exit;
	}

	$id_oeuvre = $dbAdapter->prepare('SELECT numero FROM Oeuvre WHERE titre=?');
	$id_oeuvre->execute(array($oeuvre));
	$id_oeuvre = $id_oeuvre->fetch();

	$verif = $dbAdapter->prepare('SELECT * FROM EtreDans WHERE id_liste=? AND numero=?');
	$verif->execute(array($id_liste,$id_oeuvre['numero']));

	if(!$id_oeuvre||$verif=$verif->fetch()){
		header('Location: '.$_SERVER['HTTP_REFERER']);
		exit;
	}
	else {
		$ajout = $dbAdapter->prepare('INSERT INTO EtreDans(numero,id_liste) VALUES (?,?)');
		$ajout->execute(array($id_oeuvre['numero'],$id_liste));
		header('Location:'.$_SERVER['HTTP_REFERER']);
	}
?>