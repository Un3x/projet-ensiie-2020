<?php

use Commande\CommandeRepository;

include '../src/Commande.php';
include '../src/CommandeRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$commandeId = $_POST['commande_id'] ?? null;
if ($commandeId) {
    $commandeRepository = new CommandeRepository($dbAdaper);
    $commandeRepository->delete($commandeId);
}

header('Location: /page_admin_commande.php');

?>