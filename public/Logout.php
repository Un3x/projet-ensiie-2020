<?php

use PplOnline\PplOnlinerepository;

include '../src/PplOnline.php';
include '../src/PplOnlineRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

session_start();
$pplonlineRepository = new PplOnlineRepository($dbAdaper);
$pplonlineRepository->justDisconnected();
session_destroy();
header("Location: /")
?>