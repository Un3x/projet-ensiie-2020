<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userUsername = $_POST['user_username'] ?? null;
$userPwd = $_POST['user_pwd'] ?? null;
$user_created_at = $_POST['user_created_at'] ?? null;
if ($userUsername && $userPwd) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->create($userUsername, $userPwd);
}

header('Location: ../');

?>