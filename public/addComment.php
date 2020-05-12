<?php


use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$content = $_REQUEST['content'] ?? null;
$id_post = $_REQUEST['id_post'] ?? null;
if ($content && $id_post) {
    $userRepository->addComment($_SESSION['username'],$id_post,$content);
    echo 1;
}