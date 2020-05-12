<?php

use User\UserRepository;

include '../src/Model/Entity/User.php';
include '../src/Model/Repository/UserRepository.php';
include '../src/Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['user_id'] ?? null;
if ($userId) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($userId);
}

header('Location: /');

?>
