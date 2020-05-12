<?php

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);

session_start();
if (isset($_POST['deactivateaccount'])) {
    $userRepository->deactivateAccount($_POST['disconnectid']);
    header('location:DeconnectUser.php');
}
else{
    header('location:home.php');
}

?>