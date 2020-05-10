<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/styles.css?v=1.0">
</head>
<body>
<link rel="stylesheet" href="Bet.css" media="screen" type="text/css" />
<?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Paris.php';
include '../src/ParisRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$parisRepository = new \Paris\ParisRepository($dbAdaper);
session_start();

if (isset($_GET['setreu'])) {
    $_SESSION['btMeeting'] = $_GET['setreu'];
    header('Location: bet.php?transition=true');
}

if (isset($_GET['betSubmit'])) {
    $idReu = $_GET['betSubmit'];
    $Reu = $reunionRepository->getReunion($idReu);
    $dateDebutReu = $Reu->getDateDebutReu()->format('H:i');
    $dateFinReu = $Reu->getDateFinReu()->format('H:i');
    $jourReu = $Reu->getDateDebutReu()->format('d/m/Y');
    $nomAsso = $reunionRepository->getNameAssoc($idReu);
    $betId = $_POST['betUsername'];
    $betRetard = $_POST['betRetard'];
    $betMise = $_POST['betMise'];
    $betUser = $userRepository->getUserById($betId);
    $betUsername = $betUser->getUsername();
    

    echo "<div class='validBet'>Vous vous apprêtez à parier $betMise points que $betUsername sera en retard de $betRetard
               à la réunion $nomAsso du $jourReu $dateDebutReu - $dateFinReu
               <button class='validBet-confirm' onclick ='window.location.href = \"transitionParis.php?registerBet=true&id_reu=$idReu&id_user=$betId&retard=$betRetard&mise=$betMise\"'> Confirmer </button>
               <button class='validBet-cancel' onclick ='window.location.href = \"bet.php?transition=true\"'> Annuler </button>
          </div>";
}

if (isset($_GET['registerBet'])) {
    $player = $_SESSION['user']->getId();
    $id_reu = $_GET['id_reu'];
    $id_user = $_GET['id_user'];
    $retard = $_GET['retard'];
    $mise = $_GET['mise'];

    $id_paris = $parisRepository->Bet($player,$id_reu,$id_user,$retard,$mise);
    $userRepository->updateUserPoints($mise,$player);
    $_SESSION['user']=$userRepository->getUser($_SESSION['username']);

    $location = 'Location: bet.php?transition=true&newBet='.$id_paris;
    header($location);
}

?>
</body>
</html>