<?php
#phpinfo();
include '../src/Demande_admin.php';
include '../src/DemandeAdminRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$demande_adminRepository = new \Demande\DemandeRepository($dbAdaper);
session_start();
// on teste la déclaration de nos variables
if (isset($_POST['username']) && isset($_POST['Nom_assoc'])) {
    $demande_adminRepository->newDemande($_POST['username'],$_POST['Nom_assoc']); 
}
?> 

<h1>Votre demande a bien été envoyée au super administrateur </h1>
<a class="nav-link" href="/userlist.php">Home</a>


