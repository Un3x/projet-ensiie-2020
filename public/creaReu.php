<?php 
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$reuRepository = new \Reunion\ReunionRepository($dbAdaper);

//$userRepository = new \User\UserRepository($dbAdaper);

session_start();

//on recupere l'id 
$userid = $_SESSION['user']->getId();

//on veut connaitre l'identifiant de la reunion créée 
$IdR=$reuRepository->MaxId();

//on gere le format des dates
//date debut
$Date_debut = $_POST['debut'];
$Date_debut2 = str_replace( "T" , " " , $Date_debut );
$Date_debut3 = $Date_debut2.":00";

//date fin
$Date_fin = $_POST['fin'];
$Date_fin2 = str_replace("T" , " " , $Date_fin );
$Date_fin3 = $Date_fin2.":00";

if ($IdR && $userid){
    $reuRepository->newReunion($_POST['nom_asso'], $IdR + 1, $Date_debut3, $Date_fin3, $userid, $_POST['descriptif']);
}


?>


<h1> Reunion créée avec succès ! </h1>

<a class="nav-link" href="/OrgaReu.php"> Retour aux reunions</a>
