<?php
//this file changes the username OR the email of the user.
//there won't be a need for him to login again after the change
//let's hope it doesn't break anything 

use User\UserRepository;

include '../../src/User.php';
include '../../src/UserRepository.php';
include '../../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactoryDepth())->createService();
$userRepository = new UserRepository($dbAdaper);

$userID=htmlspecialchars($_POST['userID']);;
if (isset($_POST['newUsername'])){
	$newUsername=$_POST['newUsername'];
	if ($newUsername==''){
		header('Location: ../modifyAccount.php?newUsername=notGiven');
		exit();
	}
	if ($userRepository->checkUser($newUsername)>0){
		header('Location: ../modifyAccount.php?newUsername=alreadyUsed');
		exit();	
	}
	if ($userID!==null){
		$sql='UPDATE "user" SET username= :newUsername WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newUsername'=>$newUsername, 'userID'=>$userID]);
		header('Location: ../modifyAccount.php?newUsername=changed');
		exit();
	}
	exit();
}

elseif (isset($_POST['newEmail'])){
	$newEmail=$_POST['newEmail'];
	
	if (!filter_var($newEmail, FILTER_VALIDATE_EMAIL)){
		header('Location: ../modifyAccount.php?newEmail=notGiven');
		exit();
	}

	if ($userRepository->checkEmail($newEmail)>0){ //check if email is already taken
		header('Location: ../modifyAccount.php?newEmail=alreadyUsed');
		exit();
	}
	if ($userID!==null){
		$sql='UPDATE "user" SET email= :newEmail WHERE id= :userID;';
		$stmt=$dbAdaper->prepare($sql);
		$stmt->execute(['newEmail'=>$newEmail, 'userID'=>$userID]);
		header('Location: ../modifyAccount.php?newEmail=changed');
		exit();
	}
}

else {
	header('Location: ../modifyAccount.php?newUsername=wtfIsThisNitorac');
}


?>
