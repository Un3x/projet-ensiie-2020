<?php

include '../src/Model/User/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$userRepository = new \User\UserRepository($dbAdaper);


if (isset($_POST['createbutton'])) {
    if (strcmp($_POST['pswrdcverf'], $_POST['pswrdc']) == 0) {
        if (!($userRepository->userExists($_POST['usernamec']))) {
            $userRepository->createUser($_POST['usernamec'], $_POST['pswrdc'], $_POST['emailc']);
            header("location:index.php?newUserSaved=1");
        } 
        else {
            header("location:index.php?newUserSaved=2");
        }
    } 
    else {
        header("location:index.php?newUserSaved=3");
    }
} 
else {
    header("location:index.php");
}


?>


<!DOCTYPE html>
<html lang="en">


<head>
    <meta charset="utf-8">
    <title>FacebIIkE</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="custom/styleindex.css">
</head>

<body>
    <div class="connectbox">
        Vous serrez bientôt redirigés vers la page de connexion
    </div>
</body>

</html>