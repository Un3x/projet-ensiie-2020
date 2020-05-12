<?php
use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username=$_SESSION['username'];
$theme=$_REQUEST['theme'];
$userRepository->unsub($username,$theme);
?>