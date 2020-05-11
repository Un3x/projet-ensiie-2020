<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/ParticipationRepository.php';
include '../src/Participation.php';


$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$assoRepository = new \Asso\AssoRepository($dbAdaper);
$reuRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);


session_start();
$_SESSION['user']=$userRepository->getUser($_SESSION['username']);
$idreu=$_GET['idreu'];
$participantsB=$userRepository->getParticipants($_GET['idreu']);
//$participants=$userRepository->IdPartiToName($participantsB->getId());

if(isset($_GET['idreu'])){
echo "<h2>";
echo "Veuillez saisir les retards des participants :";
echo "</h2>";



$name=[];
echo "<form action='ajoutRetardBase.php?idreu=$idreu' method='POST'>";
	
foreach ($participantsB as $part){
	if($participationRepository->isOui($idreu,$userRepository->NameToId($part))){
		echo "Retard de ".$part.": ";
		echo "<input type='time' name='retards[]'>";
		$name[]=$part;
		echo "</br>";
		echo "</br>";
	}
}

echo '<input type="submit" name="saisie_retard">';
echo "</form>";
}
?>