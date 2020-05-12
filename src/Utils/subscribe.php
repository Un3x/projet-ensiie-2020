<?php

session_start();
use User\UserRepository;

include_once '../Model/Entity/User.php';
include_once '../Model/Repository/UserRepository.php';
include_once '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper); 

 if (isset($_POST['subscribe'])) {

	$userRepository -> follow($_POST['subscribe'],$_SESSION['user_name']);
 }

header('Location: ../View/home.php');

?>