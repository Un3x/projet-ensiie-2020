<?php

use User\UserRepository;

include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username']?? null;
session_start();
if ($username) {
    $userRepository->unfollow($_SESSION['username'], $username);
}

