<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

$nb_id = $userRepository->nb_users();

session_start();
// on teste la déclaration de nos variables
if (isset($_POST['username']) && isset($_POST['email']) && isset($_POST['pass'])) {
	$userRepository->newUser($nb_id+1 ,$_POST['username'],$_POST['email'],$_POST['pass']); 
}
?> 
<h1>Votre compte a bien été créé </h1>
<a class="nav-link" href="/index.php">Home</a>