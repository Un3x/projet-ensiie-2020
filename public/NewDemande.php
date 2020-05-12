<?php
#phpinfo();
include '../src/Demande_admin.php';
include '../src/DemandeAdminRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$demande_adminRepository = new \Demande\DemandeRepository($dbAdaper);
session_start();

$userName = $_SESSION['username'] ?? null;
// on teste la déclaration de nos variables
if ($userName && isset($_POST['Nom_assoc'])) {
    $demande_adminRepository->newDemande($userName,$_POST['Nom_assoc']); 
}
?> 

<h1>Votre demande a bien été envoyée au super administrateur </h1>
<a class="nav-link" href="/agenda.php">Home</a>


