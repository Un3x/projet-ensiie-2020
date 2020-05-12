<?php
/*******/
/* this file changes the username, the email, OR the password of the user. (only one of those things at the time)
/* there won't be a need for him to login again after the change
/* let's hope it doesn't break anything in the db ᕕ( ᐛ )ᕗ
 *
 * the form from ../modifyUser.php will send via POST:
 * -newUsername
 * -newEmail
 * -newPassword
 * -newPasswordCheck
/*******/
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
use User\UserRepository;

include 'Users/User.php';
include 'Users/UserRepository.php';
include 'Factory/DbAdaperFactory.php';

include_once "ddosPrevention.php";
if ($_SESSION['sleepState']==1){
	$username=$_SESSION['username'];
	$email=$_SESSION['email'];
	header("Location: ../modifyUser.php?errs=tooManyRequest&newUsername=$username&newEmail=$email");
	exit();
}

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$userID=htmlspecialchars($_SESSION['id']);

//check if the password is correct
$sql='SELECT * FROM "user" WHERE id= :userID;';
$getOldPassword=$dbAdaper->prepare($sql);
$getOldPassword->bindParam('userID',$userID, PDO::PARAM_INT);
$getOldPassword->execute();
$trueOldPassword=$getOldPassword->fetch();
if (!password_verify($_POST['currentPassword'],$trueOldPassword['password']))
{
	//the user has not given his old password
	header('Location: ../modifyUser.php?password=wrongPsw');
	exit();
}

//to change your username, you only need to give a new one (newUsername) (as long as it's not already used by someone)
if (isset($_POST['newUsername']) && $_POST['newUsername']!=$_SESSION['username'])
{
	$newUsername=$_POST['newUsername'];

	if ($newUsername=='')
	{
		header('Location: ../modifyUser.php?username=notGiven');
		exit();
	}
	if (strlen($newUsername)>20){
		header('Location: ../modifyUser.php?username=tooLong');
		exit();
	}

	
	if (strpos($newUsername,' '))
	{
		header("Location: ../modifyUser.php?username=spaceFound");
		exit();
	}

	if ($userRepository->checkUser($newUsername)>0)
	{
		header("Location: ../modifyUser.php?username=alreadyUsed&newUsername=$newUsername");
		exit();	
	}
	if ($userID!==null)
	{
		$sql='UPDATE "user" SET username= :newUsername WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newUsername'=>$newUsername, 'userID'=>$userID]);
		$_SESSION['username']=$newUsername;
		header('Location: ../modifyUser.php?username=changed');
		exit();
	}
	exit();
}

//to change your email, you only need to give a new one (newEmail) (as long as it's not already used by someone)
if (isset($_POST['newEmail']) && $_POST['newEmail']!=$_SESSION['email'])
{

	$newEmail=$_POST['newEmail'];
	
	if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
	{
		header('Location: ../modifyUser.php?email=invalid');
		exit();
	}

	if ($userRepository->checkEmail($newEmail)>0)
	{ 
		//check if email is already taken
		header('Location: ../modifyUser.php?email=alreadyUsed');
		exit();
	}
	if ($userID!==null)
	{
		try{
			$sql='UPDATE "user" SET email= :newEmail WHERE id= :userID;';
			$stmt=$dbAdaper->prepare($sql);
			$stmt->execute(['newEmail'=>$newEmail, 'userID'=>$userID]);
			$_SESSION['email']=$newEmail;
			header('Location: ../modifyUser.php?email=changed');
			exit();
		}
		catch (PDOException $err){
			header('Location: ../modifyUser.php?err=sqlerror');
		}
	}
}

//to change your password:
//give your old password (currentPassword)
//give your new password, and double check it (newPassword and newPasswordCheck)
if (isset($_POST['newPassword']) && strlen($_POST['newPassword'])>7 )
{

	$newPassword=$_POST['newPassword'];
	$newPasswordCheck=$_POST['newPasswordCheck'];
	$currentPassword=$_POST['currentPassword'];
	
	if (strcmp($newPassword,$newPasswordCheck)!=0)
	{
		header('Location: ../modifyUser.php?password=noMatch');
		exit();
	}
	
	if (strlen($newPassword)<8)
	{
		header('Location: ../modifyUser.php?password=tooSmall');
		exit();
	}

	if ($userID!==null)
	{
	try{

		$newPasswordHash=password_hash($newPassword,PASSWORD_DEFAULT);
		$sql='UPDATE "user" SET password= :newPassword WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newPassword'=>$newPasswordHash, 'userID'=>$userID]);
		header('Location: ../modifyUser.php?password=changed');
		exit();
	}
	catch (PDOException $err) 
	{
		header('Location: ../modifyUser.php?err=sqlerror');
	}

	}
}

if (isset($_POST['newPort']) && $_POST['newPort']!=$_SESSION['port'])
{
	if (!is_numeric($_POST['newPort'])){
		header('Location: ../modifyUser.php?port=invalidPort');
		exit();
	}
	else {
		try{
			$newPort=$_POST['newPort'];
			$sql='UPDATE "user" SET port= :newPort WHERE id= :userID;';
			$stmt=$dbAdaper->prepare($sql);
			$stmt->execute(['newPort'=>$newPort, 'userID'=>$userID]);
			$_SESSION['port']=$newPort;
			header('Location: ../modifyUser.php?port=changed');
			exit();
		}
		catch (PDOException $err) {
			header('Location: ../modifyUser.php?err=sqlError');
			exit();
		}
	}
}



else {
	header('Location: ../modifyUser.php');
}


?>
