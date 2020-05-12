<?php

/* Cette page sert à récupérer l'action demandée par l'utilisateur, 
et charge la vue correspondante dans le fichier viewManager.php */

include_once 'viewManager.php';


try{
	if (!isset($_GET['action'])) {

		viewFeed(strip_tags($_SESSION['user_name']));
	}
	
	else {
		switch (strip_tags($_GET['action'])) {	// strip_tags supprime les balises et les octets nuls
			case "viewFeed":
				viewFeed(strip_tags($_SESSION['user_name']));
				break;
			case "viewFollowers":
				viewFollowers(strip_tags($_SESSION['user_name']));
				break;
			case "viewFollows":
				viewFollowings(strip_tags($_SESSION['user_name']));
				break;
			case "viewMyTweets" :
				viewMyTweets(strip_tags($_SESSION['user_name']));	
				break;
			case "usersList" :
				viewUsersList(strip_tags($_SESSION['user_name']));
				break;
			case "viewOtherUsers" :
				viewOtherUsers(strip_tags($_GET['pseudo']));
				break;
			case "hashtags" :
				viewHashtags();
				break;
			default:
				viewFeed(strip_tags($_SESSION['user_name']));
				break;
		}
	}
}
catch(Exception $e){
	echo 'Erreur : '.$e->getMessage();
}
?>