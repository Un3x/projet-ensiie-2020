<?php
use User\UserRepository;
session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$id_post = $_REQUEST['id_post'] ?? null;
$username = $_REQUEST['username'] ?? null;
if ($id_post ) {
        $userRepository->likePost($id_post,$username);
        echo $username;
        echo $id_post;
    }
