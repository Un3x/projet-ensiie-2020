<?php
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

use Lector\LectorRepository;

include 'Lectors/Lector.php';
include 'Lectors/LectorRepository.php';
include 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$lectorId = $_POST['lector_id'] ?? null;
if ($lectorId) {
    $lectorRepository = new LectorRepository($dbAdaper);
    $lectorRepository->delete($lectorId);
}

header('Location: /');

?>
