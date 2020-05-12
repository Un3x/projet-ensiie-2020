<?php

use User\UserRepository;

include '../src/aliment.php';
include '../src/alimentRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['user_id'] ?? null;
if ($userId) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($userId);
}

header('Location: /');

?>