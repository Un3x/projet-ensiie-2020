<?php

use User\UserRepository;

include '../Model/Entity/User.php';
include '../Model/Repository/UserRepository.php';
include '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userName = empty($_POST['user_name']) ? null : $_POST['user_name'] ;
if ($userName) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($userName);
}

header('Location: ../View/index.php');

?>