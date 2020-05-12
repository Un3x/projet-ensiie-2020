<?php

/* On inclut la bibliothèque Arise pour OAuth. */
require_once("/usr/share/php/ariseid/client/OAuthAriseClient.php");

/*
   Le fichier config.inc.php contient les informations d'identifications.
   Elles sont à garder précieusement : attention aux droits du fichier !
*/
/*
  config.inc.php contient les variables suivantes :
	$consumer_key = 'bc323b713288ac871a33e372c9b1bd92';
	$consumer_secret = 'c36df8385b6f333ce0b4dae055edd5d5';
	$consumer_private_key = '71f3cf528bc87ba88d0af1b3ed2db1ad';
*/
require_once("./config.inc.php");

/*
   On crée l'objet Consumer qui va vous permettre d'interagir avec Arise :
   on lui fournit les trois informations données lors de la création de
   l'application dans le chapitre précédent.
*/
$consumer = OAuthAriseClient::getInstance($consumer_key, $consumer_secret, 
	$consumer_private_key);

if (isset($_POST['login'])) {
	/*
	   L'utilisateur a cliqué sur le bouton de connexion.
	   Nous allons donc l'authentifier.
	*/
	$consumer->authenticate();
}

if (isset($_POST['logout'])) {
	/* 
	   L'utilisateur a cliqué sur le bouton de déconnexion.
	   Nous allons donc effacer ses informations d'authentification.
	*/
	$consumer->logout();
}

if ($consumer->has_just_authenticated()) {
	/*
	   Lorsqu'un utilisateur vient de s'authentifier auprès d'un service,
	   les bonnes pratiques recommandent de renouveler son identifiant
	   de session pour éviter les attaques par fixation de session.
	   C'est ce que fait ici ``session_regenerate_id``. Cependant,
	   pour permettre au SLO de fonctionner, vous devez notifier la
	   bibliothèque Arise que cet identifiant a changé,
	   c'est ce que permet ``$consumer->session_id_changed``.
	*/
	
	session_regenerate_id(TRUE);
	/*
	   Il est plus propre et efficace de faire cet appel regroupé
	   avec tous les autres (donc entre un $consumer->api()->begin()
	   et un done() mais pour l'exemple c'est plus lisible.
	*/
	$consumer->session_id_changed();
}

if ($consumer->is_authenticated()) {
	/*
	   Ici l'utilisateur est authentifié, c'est à dire qu'il s'est
	   connecté à AriseID et nous a autorisé à accéder à ses
	   informations privées.
	   Attention les autorisations facultatives n'ont pas forcément
	   été données. Il existe deux méthodes pour le savoir :
	    * tenter l'appel et vérifier l'erreur renvoyée ou,
	    * faire d'abord un appel à ``$consumer->api()->get_authorizations()``
			qui renverra un tableau avec toutes les
			autorisations que l'utilisateur a données.
	*/

	/*
	   Il existe deux moyens de faire des appels à l'API Arise :
	    * $resultat = $consumer->api()
		->mon_appel($argument1, $argument2) : 
			cet appel va envoyer une requête immédiatement à
			Arise pour exécuter l'appel et le retour de la
			fonction sera le résultat renvoyé par Arise.
	   		Une exception sera générée en cas d'erreur.
	    * $results = $consumer->api()->begin()
		->mon_appel1($argument1, $argument2)
		->mon_appel2()->done() :
			cet appel permet d'envoyer simultanément
			plusieurs requêtes à Arise. Cette méthode
			doit être préférée car plus efficace.
	   Cet ensemble d'appels renvoie un tableau de résultats.
	   Nous allons voir ci-dessous comment accéder à chaque résultat.
	*/
	$results = $consumer->api()->begin()
		->get_identifiant()
		->get_prenom()
		->get_statut_aeiie()
		->done();

	/*
	   Nous accédons au résultat en faisant un appel : ``$result[0]``
	   correspond à un résultat et nous l'appelons : ``$result[0]()``.
	   Cet appel générera une exception si Arise a renvoyé une erreur
	   lors de l'appel. Sinon, la valeur de retour est le résultat
	   de l'appel que nous affichons ici.
	*/
	try {
		$ident = $results[0]();
		echo "Bonjour ".$ident." !";
	}
	catch(OAuthAPIException $e) {
		echo "Erreur : ".$e->getMessage();
	}

	/*
	   Nous faisons de même avec les autres résultats.
	   Ils sont dans le même ordre que les appels ci-dessus.
	*/
	try {  
		$prenom = $results[1]();
		echo "Kikoooo ".$prenom." !!!";
	}
	catch(OAuthAPIException $e) {
		echo "Erreur : ".$e->getMessage();
	}

	try {  
		$bde = $results[2]();
		echo "Tu es un adhérent AEIIE : ".
			($bde ? "oui" : "non")." !!!";
	}
	catch(OAuthAPIException $e) {
		echo "Erreur : ".$e->getMessage();
	}

/*
   Ici nous affichons les moyens de se déconnecter. Avec AriseID il est
   possible de se déconnecter simultanément de toutes les applications
   en même temps. C'est le Single Logout (SLO).
   Une application bien développée devrait permettre à ses utilisateurs
   de le faire.

   L'appel à ``$consumer->get_single_logout_uri($callback)`` renvoie
   l'URL vers laquelle rediriger l'utilsateur lorsqu'il veut se
   déconnecter.
   L'argument de la fonction est l'URL vers laquelle l'utilisateur sera
   redirigé ensuite : votre page principale par exemple.
*/
?>
    <form method="post">
    <input type="submit" name="logout" value="D&eacute;connexion"/>
    </form>
    <a href="<?php echo $consumer->get_single_logout_uri(
	OAuthAriseClient::getScriptURL()) ?>">
	D&eacute;connexion de AriseID
    </a>
<?php

}
else {
/*
   Ici, nous ne sommes pas authentifiés. Nous affichons donc un bouton
   pour initier la connexion.
*/
?>
	<form method='POST'>
		<input type='submit' value='Log In with AriseID'
			name='login' />
	</form>
<?php
}
?>
