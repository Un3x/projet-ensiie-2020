<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$userName = $_SESSION['username']??null;
$newP= $_POST['newP'];
if ($userName) {
    $userRepository->modifyPSWD($userName,$newP);
}


?>

<h1>Votre mot de passe a bien été modifié </h1>
<a class="nav-link" href="/index.php"> Home</a>