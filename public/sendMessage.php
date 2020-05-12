<?php


use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$content = $_REQUEST['content'] ?? null;
$username = $_REQUEST['username'] ?? null;
if ($content) {
    $userRepository->sendMessage($_SESSION['username'],$username,$content);
    echo 1;
}