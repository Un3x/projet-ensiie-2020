<?php

use PplOnline\PplOnlineRepository;

include '../src/PplOnline.php';
include '../src/PplOnlineRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$pplOnlineRepository = new PplOnlineRepository($dbAdaper);
$pplOnlineRepository->update($pplOnlineNom, $pplOnlineMdp);

?>