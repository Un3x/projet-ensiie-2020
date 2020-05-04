<?php

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$userName = $_SESSION['username']??null;
$newU= $_POST['newU'];
if ($userName) {
    $userRepository->modifyUsName($userName,$newU);
}


?>

<h1>Votre nom d'utilisateur a bien été modifié </h1>
<a class="nav-link" href="/index.php"> Home</a>