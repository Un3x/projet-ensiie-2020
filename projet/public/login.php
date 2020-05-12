<?php

include '../src/Factory/DbAdaperFactory.php';

$pseudo=addslashes($_POST['username']);
$pwd=addslashes($_POST['password']);

$dbAdapter = (new DbAdaperFactory())->createService();
$sql = $dbAdapter->prepare("SELECT * FROM Utilisateur WHERE pseudo ='$pseudo' AND mot_de_passe ='$pwd'");
$sql->execute();
$result = $sql->fetch();

if (isset($_POST['username']) && isset($_POST['password'])) {

	if ($result) {

		session_start ();

		$_SESSION['statut'] = $result['statut'];
		$_SESSION['banni'] = $result['banni'];
		$_SESSION['username'] = $_POST['username'];
		$_SESSION['password'] = $_POST['password'];
		$_SESSION['mail'] = $result['mail'];

		header ('location: index.php');
	}
	else {

		echo '<body onLoad="alert(\'Membre non reconnu...\')">';
		echo '<meta http-equiv="refresh" content="0;URL=index.php">';
	}
}
else {
	echo 'Les variables du formulaire ne sont pas déclarées.';
}
?>

