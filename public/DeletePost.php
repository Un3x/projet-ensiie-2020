<?php

include '../src/Model/Post/Post.php';
include '../src/Model/Post/PostRepository.php';

include '../src/Model/Comment/Comment.php';
include '../src/Model/Comment/CommentRepository.php';


include '../src/Factory/DbAdaperFactory.php';


$dbAdaper = (new DbAdaperFactory())->createService();

$postRepository = new \Post\PostRepository($dbAdaper);
$commentRepository = new \Comment\CommentRepository($dbAdaper);

session_start();
if (isset($_POST['buttondeletepost'])) {
    $postRepository->deleteByID($_POST['posttodelete']);
    $commentRepository->deleteByID($_POST['posttodelete']);
    header('location:home.php');
}
else{
    header('location:home.php');
}
