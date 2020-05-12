<?php


use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
    $dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
    $id_post = $_REQUEST['id_post'] ?? null;
    if ($id_post) {
        if ($_SESSION['username'] == $userRepository->fetchPost($id_post)->getAuthor() || $_SESSION['admin']) {
            $userRepository->deletePost($id_post);
            echo 1;
        }
    }