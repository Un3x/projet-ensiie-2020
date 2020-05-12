<?php

session_start();
use Tweet\TweetRepository;

include_once '../Model/Entity/Tweet.php';
include_once '../Model/Repository/TweetRepository.php';
include_once '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$tweetRepository = new \Tweet\TweetRepository($dbAdaper); 

if (isset($_POST["like"])) {

	$id_tweet = $_POST["like"];
	$isliked = $tweetRepository -> isLiked($id_tweet,$_SESSION['user_name']);

	if($isliked == 0) {			 // l'utilisateur n'a pas encore liké ce tweet
		$tweetRepository -> likeTweet($id_tweet,$_SESSION['user_name']);
	}
}
 
header('Location: ../View/home.php');

?>