<?php

use User\UserRepository;

include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
$email = $_REQUEST['email'];
if ($userRepository->userExists($username)) {
    echo 0;
} else {
    $userRepository->register($username, $password, $email);
    $_SESSION['username'] = $username;
    $_SESSION['email'] = $email;
    $_SESSION['admin'] = false;
    echo 1;
}



