<?php

include '../src/Model/User/User.php';
include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);

session_start();

if (isset($_GET['changetype'])){
    $change = $_GET['changetype'];
}
else{
    $change = 0;
}


if ($change == 1){
    $userRepository->changeUsername($_SESSION['id'], $_POST['usernamechange']);
    header("location:settings.php?changes=1");
}
else if ($change == 2) {
    $userRepository->changeEmail($_SESSION['id'], $_POST['emailchange']);
    header("location:settings.php?changes=2");
}
else if ($change == 3) {
    $userRepository->changePassword($_SESSION['id'], $_POST['passchange']);
    header("location:settings.php?changes=3");
}
else if ($change == 4) {
    $userRepository->changeSlogan($_SESSION['id'], $_POST['sloganchange']);
    header("location:settings.php?changes=4");
}
else if ($change == 5) {
    $userRepository->changeDescript($_SESSION['id'], $_POST['descriptchange']);
    header("location:settings.php?changes=5");
}
else{
    header('location:settings.php');
}



?>