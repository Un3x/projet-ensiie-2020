<?php


use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$id_comment = $_REQUEST['id_comment'] ?? null;
if ($id_comment) {
    if ($_SESSION['username'] == $userRepository->fetchComment($id_comment)->getAuthor() || $_SESSION['admin']) {
        $userRepository->deleteComment($id_comment);
        echo 1;
    }
}