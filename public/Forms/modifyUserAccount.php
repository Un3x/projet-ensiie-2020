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

$dbAdaper = (new DbAdaperFactoryDepth())->createService();
$userRepository = new UserRepository($dbAdaper);

$userID=htmlspecialchars($_POST['userID']);

//to change your username, you only need to give a new one (newUsername) (as long as it's not already used by someone)
if (isset($_POST['newUsername']))
{
	if (isset($_POST['newEmail']) || isset($_POST['newPassword']))
	{
		//here the user tries to change more than 1 of his parameter, which is not allowed
		header('Location: ../modifyAccount.php?modify=error');
		exit();
	}

	$newUsername=$_POST['newUsername'];

	if ($newUsername=='')
	{
		header('Location: ../modifyAccount.php?newUsername=notGiven');
		exit();
	}
	if ($userRepository->checkUser($newUsername)>0)
	{
		header('Location: ../modifyAccount.php?newUsername=alreadyUsed');
		exit();	
	}
	if ($userID!==null)
	{
		$sql='UPDATE "user" SET username= :newUsername WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newUsername'=>$newUsername, 'userID'=>$userID]);
		header('Location: ../modifyAccount.php?newUsername=changed');
		exit();
	}
	exit();
}

//to change your email, you only need to give a new one (newEmail) (as long as it's not already used by someone)
elseif (isset($_POST['newEmail']))
{
	if (isset($_POST['newUsername']) || isset($_POST['newPassword']))
	{
		//here the user tries to change more than 1 of his parameter, which is not allowed
		header('Location: ../modifyAccount.php?modify=error');
	}

	$newEmail=$_POST['newEmail'];
	
	if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL))
	{
		header('Location: ../modifyAccount.php?newEmail=notGiven');
		exit();
	}

	if ($userRepository->checkEmail($newEmail)>0)
	{ 
		//check if email is already taken
		header('Location: ../modifyAccount.php?newEmail=alreadyUsed');
		exit();
	}
	if ($userID!==null)
	{
		$sql='UPDATE "user" SET email= :newEmail WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newEmail'=>$newEmail, 'userID'=>$userID]);
		header('Location: ../modifyAccount.php?newEmail=changed');
		exit();
	}
}

//to change your password:
//give your old password (oldPassword)
//give your new password, and double check it (newPassword and newPasswordCheck)
elseif (isset($_POST['newPassword']))
{
	//dans le cas d'un nouveau mot de passe, on demande à l'utilisateur de donner son ancien mot de passe
	if (isset($_POST['newEmail']) || isset($_POST['newUsername']))
	{
		//here the user tries to change more than 1 of his parameter, which is not allowed
		header('Location: ../modifyAccount.php?modify=error');
	}

	$newPassword=$_POST['newPassword'];
	$newPasswordCheck=$_POST['newPasswordCheck'];
	$oldPassword=$_POST['oldPassword'];
	
	if (strcmp($newPassword,$newPasswordCheck)!=0)
	{
		header('Location: ../modifyAccount.php?newPassword=noMatch');
		exit();
	}
	
	if (strlen($newPassword)<8)
	{
		header('Location: ../modifyAccount.php?newPassword=tooSmall');
		exit();
	}

	if ($userID!==null)
	{
	try{
		$sql='SELECT * FROM "user" WHERE id= :userID;';
		$getOldPassword=dbAdaper->prepare($sql);
		$getOldPassword->bindParam('userID',$userID);
		$getOldPassword->execute();
		$trueOldPassword=$getOldPassword->fetch();
		if (password_verify($oldPassword,$trueOldPassword['password']))
		{
			//the user has not given his old password
			header('Location: ../modifyAccount.php?newPassword=wrongPsw');
			exit();
		}

		$newPasswordHash=password_hash($newPassword,PASSWORD_DEFAULT);
		$sql='UPDATE "user" SET password= :newPassword WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newPassword'=>$newPasswordHash, 'userID'=>$userID]);
		header('Location: ../modifyAccount.php?newPassword=changed');
		exit();
	}
	catch (PDOException $err) {
		header('Location: ../modifyAccount.php?err=sqlerror');
	}

	}
}


else {
	header('Location: ../modifyAccount.php?newUsername=wtfIsThisNitorac');
}


?>
