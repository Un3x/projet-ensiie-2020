<?php

use Demande\DemandeRepository;
//use \Demande\DemandeAdminRepository;

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$username = $_POST['username'] ?? null;
if ($username) {
    $userRepository = new DemandeAdminRepository($dbAdaper);
    $userRepository->accept_admin($username);
}
header('Location: /');

?>

<h1>Votre demande a bien été acceptée </h1>
<a class="nav-link" href="/Adminlist.php">Home</a>

