<?php


use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$content = $_REQUEST['content'] ?? null;
$theme = $_REQUEST['theme'] ?? null;
if ($content) {
    $userRepository->addPost($_SESSION['username'],$content,$theme);
    echo 1;
}