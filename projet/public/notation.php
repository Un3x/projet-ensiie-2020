<?php 

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$note=$_GET['note'];

	$numero_oeuvre = $dbAdapter->prepare('SELECT * FROM Oeuvre WHERE Oeuvre.titre=?');
	$numero_oeuvre->execute(array($_GET['contenu']));
	$numero = $numero_oeuvre->fetch();

	$req = $dbAdapter->prepare('SELECT * FROM Noter WHERE Noter.pseudo = ? AND Noter.numero = ?');
	$req->execute(array($_SESSION['username'],$numero['numero']));

	if ($req = $req->fetch()){
		$req = $dbAdapter->prepare('DELETE FROM Noter WHERE Noter.pseudo = ? AND Noter.numero = ?');
		$req->execute(array($_SESSION['username'],$numero['numero']));
	}

	$noter = $dbAdapter->prepare('INSERT INTO Noter (pseudo,numero,note) 
		VALUES (?,?,?)');
	$noter->execute(array($_SESSION['username'],$numero['numero'],$note));

	header('Location: ./resultat-search.php?contenu='.$_GET['contenu']);
?>