<html>
<head>
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
<link rel="stylesheet" href="css/styles.css?v=1.0">
</head>
<body>
<link rel="stylesheet" href="Bet.css" media="screen" type="text/css" />

<?php
include 'stat.php';
include '../src/User.php';
include '../src/UserRepository.php';
/*include '../src/Paris.php';
include '../src/ParisRepository.php';
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';
include '../src/Factory/DbAdaperFactory.php';*/
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);
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
    $betRetardPrint = explode(":",$betRetard);
    $hRetard = $betRetard[1];
    $mRetard = $betRetard[0];
    $betRetardPrint = $hRetard."h".$mRetard."min";

    echo "<div class='validBet'>Vous vous apprêtez à parier $betMise points que $betUsername sera en retard de $betRetardPrint (+ ou - 5min)
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

if (isset($_GET['getResult'])) {
    $Bet = $parisRepository->getParisByIdParis($_GET['getResult']);
    $idBet = $Bet->getIdParis();
    $idReu = $Bet->getIdReu();
    $idMembre = $Bet->getIdUser();
    $mise = $Bet->getMise();
    $statut = $Bet->getStatut();
    
    $Participation = $participationRepository->getUniqueParticipation($idReu,$idMembre);
    $nomMembre = $userRepository->getUserById($idMembre)->getUsername();
    $delayf = $Participation->getRetard();
    $delayPrint = explode(":",$delayf);
    $hDelay = $delayPrint[0];
    $mDelay = $delayPrint[1];
    $delayPrint = $hDelay."h".$mDelay."min";

    $betDelay = $Bet->getRetard();

    $betDelayPrint = explode(":",$betDelay);
    $hbetDelay = $betDelayPrint[0];
    $mbetDelay = $betDelayPrint[1];
    $betDelayPrint = $hbetDelay."h".$mbetDelay."min";
    if ($statut==2) {

        $parisRepository->updateStatus($idBet,4);
        $cote = cote_basique($delayf,$idMembre,$idReu);
        $gain = $cote*$mise;
        $Gain = round($gain,2);

        echo "<div class='bet-result'>
                <div class='bet-result-content'>$nomMembre à eu $delayPrint de retard.</div>
                <div class='bet-result-content'>Vous aviez parié sur $betDelayPrint de retard.</div>
                <div class='bet-result-content'>Félicitations! Vous avez gagné $Gain € !!</div>
                <button class='bet-result-gain' onclick ='window.location.href = \"transitionParis.php?wonBet=$idBet&wonGain=$Gain\"'>Empochez vos gains</button>
              </div>";

    }
    if ($statut==3) {

        $parisRepository->updateStatus($idBet,5);
        echo "<div class='bet-result'>
                <div class='bet-result-content'>$nomMembre à eu $delayPrint de retard.</div>
                <div class='bet-result-content'>Vous aviez parié sur $betDelayPrint de retard.</div>
                <div class='bet-result-content'>Essayez une prochaine fois !</div>
                <button class='bet-result-retour' onclick ='window.location.href = \"transitionParis.php?lostBet=$idBet\"'>Retour</button>
              </div>";
    }
}

if (isset($_GET['wonBet'])) {
    $idParis = $_GET['wonBet'];
    $Gain = - $_GET['wonGain'];
    $player = $_SESSION['user']->getId();
    $parisRepository->updateStatus($idParis,4);
    $userRepository ->updateUserPoints($Gain,$player);
    $_SESSION['user'] = $userRepository->getUser($_SESSION['username']);
    header('Location: bet.php?transition=true');
}

if (isset($_GET['lostBet'])) {
    $idParis = $_GET['lostBet'];
    $parisRepository->updateStatus($idParis,5);
    header('Location: bet.php?transition=true');
}

?>
</body>
</html>