<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$username = $_POST['user_id'] ?? null;
if ($username) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($username);
}

header('Location: /');

?>
