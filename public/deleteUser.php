<?php 

use User\UserRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$id = $_SESSION['user']->getId();

if ($id){
    $userRepository->deleteUser($id);
}

?>
<h1>Votre compte a bien été supprimé </h1>
<a class="nav-link" href="/index.php"> Home</a>