<?php
//******
//This page is used to log a user on the website, if the infos from login.php are correct
//what to add: rights, experience, also maybe a password (if we so desired)
//*****

use User\UserRepository;

include '../../src/User.php';
include '../../src/UserRepository.php';
include '../../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactoryDepth())->createService();
$userRepository = new UserRepository($dbAdaper);

$token=htmlspecialchars($_POST['post.token']);
$trueToken=$_SESSION['post.token'];
$username=htmlspecialchars($_POST['username']);
$email=htmlspecialchars($_POST['email']);

//chck if the session if valid, in order to prevent malicious POST
if ($token!==$trueToken){
	header("Location: ../login.php");
}
//check validity of given userName

if ($username==''){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../login.php?errs=noUsername&email=$email");
	}
	else {
		header("Location: ../login.php?errs=noUsername");
	}
	exit();
}
elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	header("Location: ../login.php?errs=invalidEmail&username=$username");
	exit();
}

//check if the user is known
if ($userRepository->checkUser($username)==0){ 
	header('Location: ../login.php?login=userUnknown');
	exit();
}

elseif ($userRepository->checkEmail($email)==0){ //check if email is already taken
	header("Location: ../login.php?login=emailUnknown&username=$username");
	exit();
}

if ($userRepository->checkUser($username)>0 && $userRepository->checkEmail($email)>0){
	$idUser=$dbAdaper->prepare('SELECT id FROM "user" WHERE username= :user AND email= :mail;' );
	$idUser->execute(['user'=>$username, 'mail'=>$email]);
	if ($idUser->rowCount()>0){

		//here the user has succesfully enter his id, we start a new session
		//$_SESSION is a global structure, we might need to add the attributes
		$idUser=$idUser->fetch();
		session_start(); //needs to be added at the very start of every html page, 
		$_SESSION['id']= $idUser['id'];
		$_SESSION['username']=$username;
		header('Location: ../index.php?login=success');
		//header('Location: /login.php?login=success');

	}
	else { 
		header('Location: ../login.php?login=failed&username=$username');
	}
}
else{

	header('Location: ../login.php');
}
 

?>
