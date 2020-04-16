<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$errsCount=0;
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
echo 'oui';
$username=$_POST['username'];
$email=$_POST['email'];

//check validity of given userName

if ($username==''){
	echo "ERROR: username not given\n";
	$errsCount= $errsCount + 1;
}
elseif ($userRepository->checkUser($username)>0){ //check if user already exist
	echo "ERROR: username already taken\n";
	$errsCount= $errsCount + 1;
}
echo 'non';
//check validity of given email
if ($email==''){
	echo "ERROR: enter email adress\n";
	$errsCount= $errsCount + 1;
}

elseif (!filter_var($email, FILTER_VALIDATE_EMAIL)){
	echo "ERROR: invalid email adress\n";
	$errsCount= $errsCount + 1;
}

elseif ($userRepository->checkEmail($email)>0){ //check if email is already taken
	echo "ERROR: email adress already taken";
	$errsCount= $errsCount + 1;
}
echo 'abon'; 
if (errsCount==0){
	$userRepository->add($username,$email);
}



header('Location: /');

?>
