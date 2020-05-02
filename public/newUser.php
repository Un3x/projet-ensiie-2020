<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);


session_start();
// on teste la déclaration de nos variables
if (isset($_POST['id']) && isset($_POST['username'])) {
	$userRepository->newUser($_POST['id'],$_POST['username'],$_POST['email'],$_POST['pass']); 
	//$userRepository->delete(2);
}
?> 
<h1>Votre compte a bien été créé </h1>
<a class="nav-link" href="/userlist.php">Home</a>