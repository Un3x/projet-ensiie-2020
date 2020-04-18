<?php
//******
//This page is used for adding a new user to the database, after checking if the infos are correct.
//File called by registration.php
//what to add: rights, experience, also maybe a password (if we so desired)
//*****
session_start();
use User\UserRepository;

include '../../src/User.php';
include '../../src/UserRepository.php';
include '../../src/Factory/DbAdaperFactory.php';

$errsCount=0;
$dbAdaper = (new DbAdaperFactoryDepth())->createService();
$userRepository = new UserRepository($dbAdaper);

$username=htmlspecialchars($_POST['username']);
$email=htmlspecialchars($_POST['email']);
$token=htmlspecialchars($_POST['post.token']);
$trueToken=$_SESSION['post.token'];

//check if the seesion is valid, in order to prevent malicious POST

if ($token!==$trueToken){
	header("Location: ../registration.php");
}
//check validity of given userName

if ($username==''){
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../registration.php?errs=noUsername&email=$email");
	}
	else {
		header("Location: ../registration.php?errs=noUsername");
	}
	exit();
}
elseif ($userRepository->checkUser($username)>0){ //check if user already exist
	if (filter_var($email, FILTER_VALIDATE_EMAIL)){
		header("Location: ../registration.php?errs=usedUsername&email=$email");
	}
	else {
		header("Location: ../registration.php?errs=usedUsername");
	}
	exit();
}

//check validity of given email

elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	header("Location: ../registration.php?errs=invalidEmail&username=$username");
	exit();
}

elseif ($userRepository->checkEmail($email)>0){ //check if email is already taken
	header("Location: ../registration.php?errs=usedEmail&username=$username");
	exit();
}

if ($errsCount==0){
	$userRepository->add($username,$email);
	header('Location: ../login.php?signup=success');
}
else{

	header('Location: ../registration.php');
}


?>
