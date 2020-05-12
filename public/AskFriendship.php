<?php

include '../src/Model/Friendship/Friendship.php';
include '../src/Model/Friendship/FriendshipRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$friendshipRepository = new \Friendship\FriendshipRepository($dbAdaper);
if (isset($_POST['redirection'])) {
    $loc =$_POST['redirection'];
} else {
    $loc = 'home.php';
}
session_start();
if (isset($_POST['user1a']) && isset($_POST['user2a'])) {
    $friendshipRepository->askFriend($_POST['user1a'], $_POST['user2a']);

    header("location:$loc");
} else {
    header("location:$loc");
}
