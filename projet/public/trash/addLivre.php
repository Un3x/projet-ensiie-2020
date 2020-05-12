<?php

use Livre\LivreRepository;
use Oeuvre\OeuvreRepository;

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Livre.php';
include '../src/LivreRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id = ??? ?? null;
$nb_pages = $_POST['nb_pages']; 
$genre = $_POST['genre_livre'] ?? null;
$langue = $_POST['langue'];

if ($id && $genre) {
    $LivreRepository = new LivreRepository($dbAdaper);
    $LivreRepository->add($id,$nb_pages,$langue,$genre);
} 
$titre = $_POST['titre_livre'] ?? null;
$lien_photo = $_POST['lien_photo_livre'] ?? null;
$date_sortie = $_POST['date_sortie_livre'] ?? null;
if ($titre && $lien_photo && $date_sortie) {
    $OeuvreRepository = new OeuvreRepository($dbAdaper);
    $OeuvreRepository->add($titre,$lien_photo,$date_sortie);
}

header('Location: /affichage_addLivre.php');

?>