<?php
//******
//This page is used to log a user on the website, if the infos from login.php are correct
//what to add: rights, experience, (if we so desired)
//
//*****
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
session_start();
use User\UserRepository;

include 'Users/User.php';
include 'Users/UserRepository.php';
include 'Factory/DbAdaperFactory.php';

include_once "ddosPrevention.php";
if ($_SESSION['sleepState']==1){
	header("Location: ../login.php?errs=tooManyRequests");
	exit();
}

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$token=$_POST['post.token'];
$trueToken=$_SESSION['post.token'];
$username=htmlspecialchars($_POST['username']);
$password=htmlspecialchars($_POST['password']);

//chck if the session if valid, in order to prevent malicious POST
if ($token!==$trueToken){
	header("Location: ../login.php");
}
//check validity of given userName

if ($username==''){
	header("Location: ../login.php?errs=noUsername");
	exit();
}
if (strlen($username)>60){
	header("Location: ../login.php?errs=longUsername");
	exit();
}
if (strpos($username," "))
{
	header("Location: ../login.php?errs=userUnknown");
}

//check if the user is known
if ($userRepository->checkUser($username)==0 && $userRepository->checkEmail($username)==0){ 
	header('Location: ../login.php?login=userUnknown');
	exit();
}

if ($password==''){
	header("Location: ../login.php?errs=noPsw&username=$username");
}
if ($userRepository->checkUser($username) + $userRepository->checkEmail($username)>0){
	$hash_password=password_hash($password,PASSWORD_DEFAULT);
	$idUser=$dbAdaper->prepare('SELECT * FROM "user" WHERE username= :user OR email= :email;' );
	$idUser->bindParam('user',$username);
	$idUser->bindParam('email',$username);
	$idUser->execute();
	//a user has been found
	if ($idUser->rowCount()>0){
		$userFound=$idUser->fetch(PDO::FETCH_BOTH);
		if (password_verify($password,$userFound['password'])){
			//here the user has succesfully enter his id, we start a new session
			//$_SESSION is a global structure, we might need to add the attributes
			session_start(); //needs to be added at the very start of every html page, 
			$_SESSION['id']= $userFound['id'];;
			$_SESSION['username']=$userFound['username'];
			$_SESSION['email']=$userFound['email'];
			$_SESSION['rights']=$userFound['rights'];
			$_SESSION['xp']=$userFound['xp'];
			$sql='SELECT * FROM userCosmetics NATURAL JOIN "user" WHERE id= :userID;';
			try {
				$cosmetics=$dbAdaper->prepare($sql);
				$cosmetics->bindParam('userID',$userFound['id']);
				$cosmetics->execute();
				$cosmetics=$cosmetics->fetch();
				$_SESSION['image']=$userFound['image'];
				$_SESSION['title']=$userFound['title'];
			}
			catch (PDOException $err){
			header('Location: ../index.php?err=sqlError');
			}
			header('Location: ../index.php?login=success');
		}
		else { 
			header("Location: ../login.php?login=failed&username=$username");
		}

	}
}
else{

	header('Location: ../login.php&oui');
}
 

?>
