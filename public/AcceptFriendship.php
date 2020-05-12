<?php

include '../src/Model/Friendship/Friendship.php';
include '../src/Model/Friendship/FriendshipRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$friendshipRepository = new \Friendship\FriendshipRepository($dbAdaper);
if(isset($_POST['redirection'])){
    $loc = $_POST['redirection'];
}
else{
    $loc ='home.php';
}
session_start();
if (isset($_POST['user1f']) && isset($_POST['user2f'])) {
    $friendshipRepository->acceptDemand($_POST['user1f'], $_POST['user2f']);
    
    header("location:$loc");
} 

else {
    header("location:$loc");
}
