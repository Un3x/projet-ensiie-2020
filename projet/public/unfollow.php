<?php 

	session_start();

	include '../src/Factory/DbAdaperFactory.php';

	$dbAdapter = (new DbAdaperFactory())->createService();

	$ami = $_POST['ami'];

	$unfollow = $dbAdapter->prepare('DELETE FROM Suivre WHERE suiveur = ? AND suivi = ?');
	$unfollow->execute(array($_SESSION['username'],$ami));
	
	header('Location: '.$_SERVER['HTTP_REFERER']);

?>