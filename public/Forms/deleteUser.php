<?php
session_start();

if ( !(isset($_SESSION['id']) && ( $_SESSION['rights'] === 1 || $_SESSION['rights'] === 2)) )
{
    echo "Please be nice and leave, OK ?";
    exit();
}

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include 'Users/User.php';
include 'Users/UserRepository.php';
include 'Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdapter);

$deletedId = htmlspecialchars($_POST['user_id']);
$deletedRights = $userRepository->getRights($deletedId);

if ( ($deletedRights <= $_SESSION['rights']) && ($deletedRights !== 2) )
{
    $userRepository->delete($deletedId);
}

header("Location: /admin.php");

?>
