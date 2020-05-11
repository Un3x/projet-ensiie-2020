<?php
session_start();

if ( !(isset($_SESSION['id']) && ( $_SESSION['rights'] === 1 || $_SESSION['rights'] === 2)) )
{
    echo "Please be nice and leave, OK ?";
    exit();
}

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include 'Lectors/Lector.php';
include 'Lectors/LectorRepository.php';
include 'Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();
$lectorRepository = new \Lector\LectorRepository($dbAdapter);

$lectorRepository->delete(htmlspecialchars($_POST['lector_id']));

header("Location: /admin.php");

?>
