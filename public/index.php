<?php
include_once '../src/utils/autoloader.php';

$dbAdaper = (new DbAdaperFactory())->createService();
session_start();

include_once '../src/View/template.php';
loadView('home');
?>

