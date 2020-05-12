<?php

include_once '../Model/Entity/User.php';
include_once '../Model/Entity/Tweet.php';
include_once '../Model/Entity/Hashtag.php';
include_once '../Model/Repository/UserRepository.php';
include_once '../Model/Repository/TweetRepository.php';
include_once '../Model/Repository/HashtagRepository.php';
include_once '../Model/Factory/DbAdaperFactory.php';

session_start();



/* on récupère les string correspondantes à un tag d'utulisateur, ou bien à un hashtag */

function parseContent($id_tweet) {

	$dbAdaper = (new DbAdaperFactory())->createService();
	$userRepository = new \User\UserRepository($dbAdaper);
	$tweetRepository = new \Tweet\TweetRepository($dbAdaper);
	$hashtagRepository = new \Hashtag\HashtagRepository($dbAdaper);


	$content = $_POST["tweet"];

 	$splitStrings = explode(" ", $content);         // split le contenu envoyé en une Array de string

    foreach ($splitStrings as $string ) {
            
        if(!empty($string) && $string[0] == '@') {         // si le premier caractère est un '@'
                 
            $taggedUser = substr($string, 1);    // $ supprime le premier caractère de $string

			// on vérifie que l'utilisateur taggé existe dans la BD et qu'il n'est pas déjà abonné à notre profil

            if (($userRepository->checkIfUserExists($taggedUser) == 1) 
            	&& (($userRepository->isFollowing($_SESSION['user_name'],$taggedUser)) == 0)
            	&& $_SESSION['user_name'] != $taggedUser)
            {

            	$tweetRepository->addToFeed($id_tweet,$taggedUser);
            }  

        }
        else if (!empty($string) && $string[0] == '#'){
            
            $hashtagRepository->addHashTag($string);
        }

     }
}


if (!(empty ($_POST["tweet"]))) {

	$dbAdaper = (new DbAdaperFactory())->createService();
	$tweetRepository = new \Tweet\TweetRepository($dbAdaper);

	$tweet = $_POST["tweet"];
	$id_tweet = $tweetRepository->sendTweet($tweet,$_SESSION['user_name']);
	parseContent($id_tweet);
}	


// le contenu du tweet est vide

header('Location: ../View/home.php');

?>