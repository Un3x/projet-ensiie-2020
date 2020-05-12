<?php
	
	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$id = $_POST['commentaire'];
	$supprimer = $dbAdapter->prepare('DELETE FROM Commentaire WHERE id=?'); //On commence par supprimer le commentaire
	$supprimer->execute(array($id));

	$personne = $_POST['personne'];
	$mute = $dbAdapter->prepare('UPDATE Utilisateur SET banni=true WHERE pseudo=?');//Puis on banni l'utilisateur 
	$mute->execute(array($personne));

	header('Location: administration.php');

?>