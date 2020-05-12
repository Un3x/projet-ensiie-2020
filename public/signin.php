<?php

use User\UserRepository;

include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username'];
$password = $_REQUEST['password'];
if ($userRepository->userCanLog($username, $password)) {
    $user = $userRepository->fetchUser($username);
    $_SESSION['username'] = $user->getUsername();
    $_SESSION['email'] = $user->getEmail();
    $_SESSION['admin'] = $user->getAdmin();
    echo 1;
} else {
    echo 0;
}
