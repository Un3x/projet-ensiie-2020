<?php

use User\UserRepository;
//use Demande\DemandeRepository;

include '../src/User.php';
include '../src/UserRepository.php';

include '../src/Demande_admin.php';
include '../src/DemandeAdminRepository.php';

include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
session_start();

$username = $_POST['username2'];

if ($username) {
    $userRepository->refuse_admin($username);
}

?>

<h1>Vous avez bien refusé la demande de cet utilisateur </h1>
<a class="nav-link" href="/index.php"> Home </a>
