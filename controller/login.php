<?php
require_once $_SERVER['DOCUMENT_ROOT'] . '/utils/autoloader.php';

$dbfactory = new Model\Factory\dbFactory();
$dbAdapter = $dbfactory->createService();

$userHydrator = new Model\Hydrator\UserHydrator();
$userRepository = new Model\Repository\UserRepository($dbAdapter, $userHydrator);

if (!empty($_POST['username']) && !empty($_POST['password'])) {
    if ($userRepository->connect($_POST['username'], $_POST['password'])) {
        $user = $userRepository->findUserByUsername($_POST['username'])[0];
        $_SESSION["id"] = $user->getId();
        $_SESSION["username"] = $user->getUsername();
        $_SESSION["role"] = $user->getRole();
        header("Location: /");
        die();
    } else {
        header("Location: /login");
        die();
    }
}
