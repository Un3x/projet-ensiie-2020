<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

//Récupération des utilisateurs ayant le pseudo donnée dnas le formulaire
$stmt = $dbAdaper->prepare('SELECT id, password, username, rle
FROM "user"
WHERE username = :username');
$stmt->bindValue(':username', $_POST['lusername'], PDO::PARAM_STR);
$stmt->execute();
$result = $stmt->fetch();

if(!$result) //Si aucun utilisateur n'es trouvé
{
	$erreur="uspassNotFound";
}
else
{
	if(strcmp($_POST['lpassword'], $result['password']) == 0) //Si les mots de passes correspondent dans la bdd
	{
		session_start();
		$_SESSION['id'] = $result['id'];
		$_SESSION['username'] = $result['username'];
		$_SESSION['role'] = $result['rle'];
		header('Location: index.php'); //Redirection sans erreur
  		exit();
	}
	else
	{
		$erreur="uspassNotFound";
	}
}

header("Location: page_connexion.php?erreur={$erreur}"); //Redirection avec erreur
exit();
?>