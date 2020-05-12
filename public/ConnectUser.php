<?php

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);


if(!($userRepository->userExists($_POST['username']))){
    header("location:index.php?issueconnect=1");
}
else 
{
    #if (($userRepository->isInactiveUser(($userRepository->fetchByName($_POST['username']))[1])['inactive'])) {
        #header("location:index.php?issueconnect=2");
    #}

    if($userRepository->connectUser($_POST['username'],$_POST['pswrd'])){
        header("location:home.php");
    }
    else {
        header("location:index.php?issueconnect=1");
    }
}
?>