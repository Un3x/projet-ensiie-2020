<?php
use User\UserRepository;
session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/InterestRepository.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$interestRepository=new \Interest\InterestRepository($dbAdaper);
$username=$_SESSION['username'];
if(isset($username)) {
    $Pref = explode(",", $_REQUEST['pref'], 13);
    foreach ($Pref as $name) {
        $userRepository->addInterested($username, $name);
    }
}
?>