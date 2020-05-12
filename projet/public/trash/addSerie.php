<?php

use Serie\SerieRepository;
use Oeuvre\OeuvreRepository;

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Serie.php';
include '../src/SerieRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id = ??? ?? null;
$nb_ep = $_POST['nb_ep'];
$nb_saisons = $_POST['nb_saisons'] ?? null;
$genre = $_POST['genre_serie'] ?? null;
$duree = $_POST['duree_serie'] ?? null;

if (document.getElementById('anime').checked){
    $anime = 1;
}
if (document.getElementById('non_anime').checked){
    $anime = 0;
}

if ($id && $nb_saisons && $genre && $duree) {
    $SerieRepository = new SerieRepository($dbAdaper);
    $SerieRepository->add($id,$nb_ep,$nb_saisons,,$duree,$genre,$anime);
} 
$titre = $_POST['titre_serie'] ?? null;
$lien_photo = $_POST['lien_photo_serie'] ?? null;
$date_sortie = $_POST['date_sortie_serie'] ?? null;
if ($titre && $lien_photo && $date_sortie) {
    $OeuvreRepository = new OeuvreRepository($dbAdaper);
    $OeuvreRepository->add($titre,$lien_photo,$date_sortie);
}

header('Location: /affichage_addSerie.php');

?>