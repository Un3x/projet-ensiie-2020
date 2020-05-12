<?php

include '../src/Model/Post/Post.php';
include '../src/Model/Post/PostRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();

$postRepository = new \Post\PostRepository($dbAdaper);

session_start();

$loc = $_POST['src'];
$postid = $_POST['posttolike'];
$locprecise= $loc.'#post'.$postid;

if (isset($_POST['likebutton'])) 
{
    $postRepository->likeByID($_POST['posttolike'],$_POST['likecount']+1);
    header("location:$locprecise");
}
if (isset($_POST['dislikebutton'])) {

    $postRepository->likeByID($_POST['posttolike'],$_POST['likecount']-1);
    header("location:$locprecise");
}
else {
    header("location:$locprecise");
}
