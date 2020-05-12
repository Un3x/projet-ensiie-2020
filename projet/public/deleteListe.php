<?php

use Liste\ListeRepository;

include '../src/Liste.php';
include '../src/ListeRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$id = $_POST['liste_id'] ?? null;
if ($id) {
    $ListeRepository = new ListeRepository($dbAdaper);
    $ListeRepository->delete($id);
}

header('Location: /mylists.php');

?>
