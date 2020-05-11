<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$assoRepository = new \Asso\AssoRepository($dbAdaper);
$reuRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);


session_start();
$participantsB=$userRepository->getParticipants($_GET['idreu']);

$name=[];
foreach ($participantsB as $part) {
	$name[]=$part;
}

$_SESSION['user']=$userRepository->getUser($_SESSION['username']);

$i=0;
$idreu=$_GET['idreu'];
if(isset($_GET['idreu'])){

	foreach ($_POST['retards'] as $part){
		$participationRepository->ajout_retard($idreu,$userRepository->NameToId($name[$i]),$part);
		$i=$i+1;
	}
}

foreach ($name as $key ) {
	if($participationRepository->isOui($idreu,$userRepository->NameToId($key))){
		$participationRepository->updateStatus($idreu,$userRepository->NameToId($key),3);
	}
}
?>

<h1>
Saisie effectuée et prise en compte
</h1>

<a class="nav-link" href="/profil.php"> Retour au profil</a>