<?php
include_once '../src/utils/autoloader.php';

$dbAdaper = (new DbAdaperFactory())->createService();

loadView('home');
?>

