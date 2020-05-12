<?php

use Oeuvre\OeuvreRepository;

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id = $_POST['oeuvreId'] ?? null;
if ($id) {
    $oeuvreRepository = new OeuvreRepository($dbAdaper);
    $oeuvreRepository->delete($id);
}

header('Location: /');

?>