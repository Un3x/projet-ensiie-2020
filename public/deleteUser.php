<?php

use User\UserRepository;

include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();
if ($_SESSION['admin']) {
    $dbAdaper = (new DbAdaperFactory())->createService();
    $username = $_REQUEST['username'] ?? null;
    if ($username) {
        $userRepository = new UserRepository($dbAdaper);
        $userRepository->deleteUser($username);
        echo 1;
    }
}