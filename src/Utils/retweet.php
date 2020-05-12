<?php
 
session_start();

include_once '../Model/Repository/TweetRepository.php';
include_once '../Model/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$tweetRepository = new \Tweet\TweetRepository($dbAdaper); 

if (isset($_POST["retweet"])) {

	$id_tweet = $_POST["retweet"];
	$tweetRepository -> retweet($id_tweet,$_SESSION['user_name']);
}
 
header('Location: ../View/home.php');

?>