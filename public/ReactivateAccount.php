<?php

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);

session_start();
if (isset($_POST['reactivateid'])) {
        $userRepository->reactivateAccount($_POST['reactivateid']);
        header('location:home.php');
}

else{
    header('location:index.php');
}

?>