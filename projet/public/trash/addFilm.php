<?php

use Oeuvre\FilmRepository;
use Oeuvre\OeuvreRepository;

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Film.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

// Ajout d'une oeuvre
$titre = $_POST['titre'] ?? null;
$lien_photo = $_POST['lien_photo'] ?? null;
$date_sortie = $_POST['date_sortie'] ?? null;
if ($titre && $lien_photo && $date_sortie) {
    $OeuvreRepository = new OeuvreRepository($dbAdaper);
    $OeuvreRepository->add($titre,$lien_photo,$date_sortie);
}

// Ajout d'un film 
$id = $dbAdaper->prepare('SELECT numero FROM Oeuvre WHERE Oeuvre.titre = :titre') ?? null;
$id2 = $id->execute();
$realisateur = $_POST['realisateur'] ?? null;
$genre = $_POST['genre_film'] ?? null;
$duree = $_POST['duree_film'] ?? null;
$producteur = $_POST['producteur'];
if ($id2 && $realisateur && $genre && $duree) {
    $FilmRepository = new FilmRepository($dbAdaper);
    $FilmRepository->add($id2,$realisateur,$genre,$duree,$producteur);
} 

header('Location: /affichage_addFilm.php');

?>