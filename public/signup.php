<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

/* $_POST contient les informations du formulaire d'inscription :
   isuername : l'identifiant de l'utilisateur, iemail: l'email de l'utilisateur, ipassword: le mdp de l'utilisateur */


//Connexion à la Bdd et récupération des fonctions utilisateurs
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);


//Vérification de la confirmation du mot de passe
if($_POST['ipassword'] == $_POST['ipasswordconfirm'])
{
	//Ajout de l'utilisateur en fonction du formulaire d'inscription
	$userInfo = array('username' => $_POST['iusername'], 'email' => $_POST['iemail'], 'password' => $_POST['ipassword']);


	try
	{
		$userRepository->addUser($userInfo);
	}
	catch(Exception $e)
	{
		$erreur = "usernameTaken"; //Si le nom d'utilisateur est déjà utilisé
	}

	if(isset($erreur))
	{
		header("Location: page_inscription.php?erreur={$erreur}");
	}
	else
	{	
	     header('Location: /');
	}

}
else {
$erreur = "passwordDoNotMatch"; //Si la confirmation de mot de passe à échoué
header("Location: page_inscription.php?erreur={$erreur}");
}

?>