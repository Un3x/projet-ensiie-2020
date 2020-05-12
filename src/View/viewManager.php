<?php

/* Cette page contient les fonctions d'affichage des vues du site 
Ces fonctions sont appellés dans le fichier loadView.php, selon l'action de l'utilisateur */

include_once '../Model/Entity/User.php';
include_once '../Model/Entity/Tweet.php';
include_once '../Model/Entity/Hashtag.php';
include_once '../Model/Repository/UserRepository.php';
include_once '../Model/Repository/TweetRepository.php';
include_once '../Model/Repository/HashtagRepository.php';
include_once '../Model/Factory/DbAdaperFactory.php';


/* Vue de la liste des followers d'un utilisateur : affiche les noms des utilisateurs qui suivent $userName */

function viewFollowers ($userName) {?>		

	<div class="titleViewFollows"> Mes abonnés </div>

	<div id="messagerie">

		<?php  

			$dbAdaper = (new DbAdaperFactory())->createService();
			$userRepository = new \User\UserRepository($dbAdaper);
			$myFollowers = $userRepository->getMyFollowers($userName);
			$userRepository->showFollows($myFollowers);
		?>
	</div>

<?php
}


/* Vue de la liste des follows d'un utilisateur : affiche les noms des utilisateurs suivis par $userName */

function viewFollowings ($userName) {?>

	<div class="titleViewFollows"> Mes abonnements </div>

	<div id="messagerie">
		<?php  

			$dbAdaper = (new DbAdaperFactory())->createService();
			$userRepository = new \User\UserRepository($dbAdaper);
			$myFollowers = $userRepository->getMyFollowings($userName);
			$userRepository->showFollows($myFollowers);
		?>
	</div>

<?php
}

/* Vue des tweets de l'utilisateur connecté : affiche les tweets de l'utilisateur, et également la zone de saisie du message */

function viewMyTweets ($userName) {  
?>
	<div id="messagerie">
		<form method="POST" action="../../src/Utils/sendTweet.php" autocomplete="off"> 
		                          
		 	<input type="text" name="tweet" id="tweet" placeholder="Contenu du tweet à envoyer" maxlength="280">  <br>
		</form>

		<div id="showTweets">
		    <?php  
		   	 	$dbAdaper = (new DbAdaperFactory())->createService();
				$tweetRepository = new \Tweet\TweetRepository($dbAdaper);
		        $myTweets = ($tweetRepository-> getMyTweets($userName)); 
		      	$tweetRepository->showTweets($myTweets);
		    ?>
		 </div>
	</div>

<?php
}

/* Vue de la liste de tous les utilisateurs : affiche les noms des utilisateurs du site,
 ceux-ci sont cliquables afin d'accéder à leurs tweets */

function viewUsersList ($userName) { ?>

	<div class="titleViewFollows"> Liste de tous les utilisateurs </div>

	<div id="messagerie">

		<?php  

			$dbAdaper = (new DbAdaperFactory())->createService();
			$userRepository = new \User\UserRepository($dbAdaper);
			$allUsers = $userRepository->fetchAll();
			$userRepository->showFollows($allUsers);
		?>
	</div>

	<?php
}



/* Vue des hashtags: affiche la liste des hashtags saisis par les différents utilisateurs */

function viewHashtags () { ?>

	<div class="titleViewFollows"> Tendances actuelles </div>

	<div id="messagerie">

		<?php  

			$dbAdaper = (new DbAdaperFactory())->createService();
			$hashtagRepository = new \Hashtag\HashtagRepository($dbAdaper);
			$hashtags = $hashtagRepository->fetchAll();
			$hashtagRepository->showHashtags($hashtags);
		?>
	</div>

	<?php
}




/* Vue d'un utilisateur, différent de celui connecté : affiche la fonctionnalité d'abonnement si on n'est pas encore abonné ,
puis affiche les tweets de celui-ci */

function viewOtherUsers($userName) { 	

	$dbAdaper = (new DbAdaperFactory())->createService();
	$userRepository = new \User\UserRepository($dbAdaper); 
	$tweetRepository = new \Tweet\TweetRepository($dbAdaper); ?>

	<div id="messagerie">

	<?php
		if(($userRepository->isFollowing($userName,$_SESSION['user_name'])) == 0 
			&& $userName != $_SESSION['user_name']) 
		{ ?>

			<div id="followName">
				<form method="POST" action="../../src/Utils/subscribe.php"> 
				                          
				 	 <button name="subscribe" id="subscribe" type="submit" value=<?php echo $userName; ?> >  
		    	Suivre <?php echo $userName; ?> </button>
				</form>
			</div>

		<?php 
		} 
		?>

		<div id="showTweets">
		    <?php  

		        $userTweets = ($tweetRepository-> getMyTweets($userName)); 
		      	$tweetRepository->showTweets($userTweets);
		    ?>
		 </div>
	</div>
<?php
}



/* Vue Feed : on récupère la liste des tweets de l'utilisateur connecté, 
de ses retweets, des tweets de ses abonnements ainsi que des tweets dans lequel celui-ci est taggé */

function viewFeed($userName) { ?>

	<div class="titleViewFollows"> Mon feed d'actualité </div>

	<div id="messagerie">

		<form method="POST" action="../../src/Utils/sendTweet.php" autocomplete="off"> 
		                          
		 	<input type="text" name="tweet" id="tweet" placeholder="Contenu du tweet à envoyer" maxlength="280">  <br>
		</form>

		<div id="showTweets">
		    <?php  
		   	 	$dbAdaper = (new DbAdaperFactory())->createService();
				$tweetRepository = new \Tweet\TweetRepository($dbAdaper);
				$userRepository = new \User\UserRepository($dbAdaper);
				$myFollowings = $userRepository->getMyFollowings($userName);

				$followingsTweets = [];
				foreach ($myFollowings as $following) {
					$user = $following -> getUsername();
					$followingsTweets = array_merge($followingsTweets,$tweetRepository-> getMyTweets($user));
				}
	
		      	$myTweets = ($tweetRepository-> getMyTweets($userName)); 
		      	$myFeed = array_merge($followingsTweets,$myTweets);
		        $myTags = ($tweetRepository-> getMyFeed($userName));
		       	$myFeed = array_merge($myFeed,$myTags);
		       	$tweetRepository->showTweets($myFeed);

		    ?>
		 </div>
	</div>

	<?php

}

?>