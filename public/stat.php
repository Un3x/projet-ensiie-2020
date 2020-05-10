<?php
include '../src/Reunion.php';
include '../src/ReunionRepository.php';
include '../src/Participation.php';
include '../src/ParticipationRepository.php';
include '../src/Paris.php';
include '../src/ParisRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$reunionRepository = new \Reunion\ReunionRepository($dbAdaper);
$participationRepository = new \Participation\ParticipationRepository($dbAdaper);
$parisRepository = new \Paris\ParisRepository($dbAdaper);
/**
 * @param $delay le retard sur lequel l'utilisateur parie
 *        $idMembre le participant sur lequel l'utilisateur parie
 *        $idReu l'id de la réunion sur laquelle l'utilisateur parie
 * @return $cote la cote du paris
 */

function cote_basique($delay,$idMembre,$idReu) {

    $Paris = $parisRepository->getParisByIdReu($idReu);
    $nombreParis = count($Paris);
    $Reunion = $reunionRepository->getReunion($idReu);
    $idAsso = $Reunion->getIdAssoc();
    $avgDelay = $participationRepository->getAverageDelay($idMembre);
    $avgDelayAsso = $participationRepository->getAverageDelayAsso($idMembre,$idAsso);

    $nbParisCoeff = 100/(100+$nombreParis);
    $avg = ($avgDelay + $avgDelayAsso)/2;
    $a = 0.9/(1200*1200);
    $b = -$avg/2;
    $c = 1.1 - b*$avg - a*$avg*$avg;
    $x = $delay->getTimestamp();
    $cote = ($a*$x*$x+$b*$x+$c)*$nbParisCoeff;
    return $cote;
}
?>