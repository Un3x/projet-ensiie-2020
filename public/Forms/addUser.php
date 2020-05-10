<?php
//******
//This page is used for adding a new user to the database, after checking if the infos are correct.
//File called by registration.php
//what to add: rights, experience, also maybe a password (if we so desired)
//*****
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
session_start();
use User\UserRepository;

include 'Users/User.php';
include 'Users/UserRepository.php';
include 'Factory/DbAdaperFactory.php';

$errsCount=0;
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$username=htmlspecialchars($_POST['username']);
$email=htmlspecialchars($_POST['email']);
$password=htmlspecialchars($_POST['password']);
$checkPassword=htmlspecialchars($_POST['checkPassword']);
$token=htmlspecialchars($_POST['post.token']);
$trueToken=$_SESSION['post.token'];

//check if the session is valid, in order to prevent malicious POST

if ($token!==$trueToken){
    header("Location: ../registration.php");
}
//check validity of given userName

if ($username=='')
{
    if (filter_var($email, FILTER_VALIDATE_EMAIL))
    {
        header("Location: ../registration.php?errs=noUsername&email=$email");
    }
    else 
    {
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

//check validity of given password
elseif (strcmp($password,$checkPassword)!=0)
{
    header("Location: ../registration.php?errs=noMatchPsw&username=$username&email=$email");
    exit();
}

elseif (strlen($password)<8)
{ 
    header("Location: ../registration.php?errs=shortPsw&username=$username&email=$email");
    exit();
}

if ($errsCount==0)
{
    try {
        $hashed_password=password_hash($password,PASSWORD_DEFAULT);
        $userRepository->add($username,$email,$hashed_password);
        header('Location: ../login.php?signup=success');
        exit();
    }
    catch (PDOException $err) {
        header('Location: ../login.php?err=sqlerror');
    }
}

else{

    header('Location: ../registration.php');
}


?>
