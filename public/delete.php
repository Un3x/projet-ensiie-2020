<?php
use Ad\AdRepository;
use User\UserRepository;
include '../src/Entities/User.php';
include '../src/Repositories/UserRepository.php';
include '../src/Entities/Ad.php';
include '../src/Repositories/AdRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$userId = $_POST['user_id'] ?? null;
if ($userId) {
    $userRepository = new UserRepository($dbAdaper);
    $userRepository->delete($userId);
    $AdRepository = new AdRepository($dbAdaper);
    $AdRepository->deleteAll($userId);
    header('Location: /espace_membre.php');
	exit();
}

$adId = $_POST['ad_id'] ?? null;
if ($adId) {
    $AdRepository = new AdRepository($dbAdaper);
    $AdRepository->delete($adId);
    header('Location: /espace_membre.php');
	exit();
}


$supId = $_POST['sup_id'] ?? null;
if ($supId) {
    $adminRepository = new UserRepository($dbAdaper);
    $adminRepository->delete($supId);
    $AdRepository = new AdRepository($dbAdaper);
    $AdRepository->deleteAll($supId);
    header('Location: /Deconnexion.php');;
	exit();
}
?>
