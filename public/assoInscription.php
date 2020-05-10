<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$assoRepository = new \Asso\AssoRepository($dbAdaper);
$id = $_SESSION['user']->getId();


$assoRepository->newMembre($id,$_POST['nomAsso'],$_SESSION['username']); 
?>
<h1> Vous avez bien été ajouté a cette association </h1>
<a class="nav-link" href="/profil.php">Retour a votre profil</a>