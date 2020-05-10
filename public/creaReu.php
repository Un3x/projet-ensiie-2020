<?php 
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

session_start();
$userid=$_SESSION['user']->getId();

$reuRepository = new \Reunion\ReunionRepository($dbAdaper);
$IdR=$reuRepository->MaxId();
$IdReu=(int)$IdR+1;

$reuRepository->newReunion($_POST['nomAsso'],$IdReu,$_POST['debut'],$_POST['fin'],$userid,$_POST['descriptif']);
?>


<h1> Reunion créée avec succés ! </h1>

<a class="nav-link" href="/OrgaReu.php"> Retour aux reunions</a>