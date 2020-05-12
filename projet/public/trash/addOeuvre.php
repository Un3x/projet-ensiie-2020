<?php

use Oeuvre\OeuvreRepository;

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$titre = $_POST['titre_oeuvre'] ?? null;
$lien_photo = $_POST['lien_photo'] ?? null;
if ($titre && $lien_photo) {
    $OeuvreRepository = new OeuvreRepository($dbAdaper);
    $OeuvreRepository->add($titre,$lien_photo, date("d/m/Y"));
}

header('Location: /affichage2.php');

?>