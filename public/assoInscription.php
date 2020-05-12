<?php
#phpinfo();
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/ParticipationRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reuRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);

session_start();
$_SESSION['user']=$userRepository->getUser($_SESSION['username']);

$assoRepository = new \Asso\AssoRepository($dbAdaper);
//$id = $_SESSION['user']->getId();
$id_membre=$_SESSION['user']->getId();
echo $_POST['nomasso'];
$assoRepository->newMembre($id_membre,$_POST['nomasso'],$_SESSION['username']); 

$id=$assoRepository->NameToId($_POST['nomasso']);
echo $id;
$reu = $reuRepository->reuAsso($id);
foreach ($reu as $r) {
	$idreu=$r->getIdReu();
	$participationRepository->insertStatus($idreu,$id_membre,2);
}

$_SESSION['user']=$userRepository->getUser($_SESSION['username']);
?>


<h1> Vous avez bien été ajouté a cette association </h1>
<a class="nav-link" href="/profil.php">Retour a votre profil</a>