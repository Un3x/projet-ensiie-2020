<?php
session_start();

if ( !isset($_SESSION['id']) )
{
    echo "Please be nice and leave, OK ?";
    exit();
}

elseif ( !(($_SESSION['rights'] === 1) || ($_SESSION['rights'] === 2)) )
{
    echo "Please be nice and leave, OK ?";
    exit();
}

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Users/User.php';
include_once 'Users/UserRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);

$currentRights = $userRepository->getRights($_POST['user_id']);
$newrights = $currentRights + $_POST['action'];

if ( ($newrights < -1) || ($newrights > 1) )
{
    echo "Unauthorized request. If you didn't do anything suspicious, please contact the owner of the website to earn a drink at the Bakabar(k) against some useful debugging information.";
    exit();
}

$userRepository->setRights($_POST['user_id'], $newrights);

// Bruh this is cringe
// Don't know why this bug with one echo and string concatenation but it does so here it is with 5 echos
echo "Changed rights of the user with the id ";
echo $_POST['user_id'];
echo " from ";
echo $newrights-$_POST['action'];
echo " to ";
echo $newrights;

header('Location: /admin.php');
?>
