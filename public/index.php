<?php
include_once '../src/utils/autoloader.php';

$dbAdaper = (new DbAdaperFactory())->createService();
session_start();

loadView('home');
?>

