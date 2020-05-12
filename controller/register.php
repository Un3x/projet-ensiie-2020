<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$userHydrator = new Model\Hydrator\UserHydrator();
$userRepository = new Model\Repository\UserRepository($dbAdapter, $userHydrator);

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    $id = $userRepository->createUser($_POST['username'], $_POST['password']);
    copy($_SERVER['DOCUMENT_ROOT']."/img/user.png", $_SERVER['DOCUMENT_ROOT']."/img/user/" . $id . ".png");
    header("Location: /");
    die();
}
