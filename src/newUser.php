<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();


session_start();
// on teste la déclaration de nos variables
if (isset($_POST['id']) && isset($_POST['username'])) {
	$userRepository->newMembre($_POST['id'],$_POST['username'],$_POST['email'],$_POST['pass']); 
}
?> 

<a class="nav-link" href="/index.php">Home</a>