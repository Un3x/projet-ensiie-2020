=============================
Bibliothèque OAuth pour Arise
=============================

OAuth est un mécanisme permettant à des applications (dans le navigateur et en dehors) d'accéder à des données des élèves, stockées chez Arise, tout en garantissant à celui-ci que ses identifiants ne soient pas communiqués et en s'assurant que les applications n'aient accès qu'aux informations qu'il désire transmettre.

 * Pour plus d'informations sur OAuth, vous pouvez lire le chapitre `OAuth pour les nuls`_.
 * Pour développer une application, commencez par `Préparation`_.
 * Si des questions et des doutes persistent, ``#arise`` est votre ami.

Préparation
===========

Avant d'utiliser la bibliothèque OAuth pour Arise, il faut :

  * se connecter sur http://oauth.iiens.net,
  * aller dans la partie *Mes applications* et en créer une nouvelle,
  * entrer un nom,
  * choisir le type d'application :

    * application dans le navigateur pour un site Web (le cas le plus courant),
    * application de bureau pour une application s'exécutant indépendamment (application Android par exemple),

  * entrer une URL de déconnexion pour le mécanisme de Single LogOut,

    * cette information est facultative. Cependant, pour une meilleure sécurité il est recommandé de la spécifier : il s'agit d'une URL qui sera appelée par AriseID lorsque l'utilisateur ferme sa session AriseID

  * choisir les différentes autorisations nécessaires au fonctionnement de l'appli.

Une fois toutes ces informations renseignées, AriseID vour fournira trois informations :

  * un identifiant et un secret vous servant à authentifier votre application auprès d'AriseID,
  * une clé privée utilisée pour garantir la confidentialité des informations stockées par la bibliothèque chez AriseID

La clé privée n'est utilisée que par la bibliothèque Arise alors que l'identifiant et le secret sont utilisés par toutes les bibliothèques OAuth.

Développement d'une application OAuth avec la bibliothèque Arise
================================================================

Méthode par l'exemple:

.. code-block:: php

	<?php

	/* On inclut la bibliothèque Arise pour OAuth. */
	/* ======================= ATTENTION ! ======================== */
	/* Ce fichier doit être inclut AVANT un appel à session_start() */
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
				fonction sera la valeur de retour renvoyée par Arise.
		   		Une exception sera générée en cas d'erreur.
		    * $results = $consumer->api()->begin()
			->mon_appel1($argument1, $argument2)
			->mon_appel2()->done() :
				cet appel permet d'envoyer simultanément
				plusieurs requêtes à Arise. Cette méthode
				doit être préférée car plus efficace.
		   Cet ensemble d'appels renvoie un tableau de fonctions permettant d'obtenir les
		   résultats. Nous allons voir ci-dessous comment accéder à chaque résultat.
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

Fonctions de la bibliothèque AriseID
====================================

``OAuthAriseClient``
--------------------

``static public function getInstance($consumer_key, $consumer_secret, $consumer_private_key)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie une nouvelle instance de client permettant de faire l'authentifcation et les appels à l'API.

Cette fonction prend les arguments suivants :

 * ``consumer_key``: l'identifiant du client donné par AriseID
 * ``consumer_secret``: le secret du client donné par AriseID
 * ``consumer_private_key``: une clé privée au consommateur, sert à chiffrer l'identifiant de session lors de son stockage sur le serveur

``public function set_callback($callback)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Définit l'URL de retour une fois que l'utilisateur s'est authentifié auprès de AriseID et accepté les autorisations.
Par défaut, l'URL de retour est l'URL de la page lors de l'appel à ``authenticate``.

Cette fonction prend l'argument suivant :

 * ``callback``: l'URL de retour

``public function authenticate()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Démarre la procédure d'authentification. Obtient un jeton temporaire et redirige l'utilisateur vers la page d'authentification AriseID. Ne retourne pas mais peut générer des exceptions.
Cette fonction est utilisée par les clients de type Web.

Cette fonction ne prend pas d'arguments.

``public function get_authorize_uri()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Démarre la procédure d'authentification. Obtient un jeton temporaire et renvoie l'URL vers laquelle l'utilisateur doit se diriger.
Cette fonction est utilisée par les clients de type bureau/OOB.

Cette fonction ne prend pas d'arguments.

``public function got_oob_verifier($verifier)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Indique à la librairie que le code de vérification affiché à l'utilisateur par le serveur OAuth a été renseigné chez le client.
Cette fonction est utilisée par les clients de type bureau/OOB.

Cette fonction prend l'argument suivant :

 * ``verifier``: le code de vérification que l'utilisateur a saisi

``public function has_just_authenticated()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie un booleen déterminant si la procédure d'authenfication vient de se terminer dans la requête courante.

Cette fonction ne prend pas d'arguments.

``public function is_authenticated()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie un booleen déterminant si l'utilisateur est authentifié.

Cette fonction ne prend pas d'arguments.

``public function api()``
~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie une instance de OAuthAPICaller qui permettra d'effectuer des requêtes à l'API AriseID.

Cette fonction ne prend pas d'arguments.

``public function logout()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Efface les jetons stockés en variable de session et réinitialise le client. L'utilisateur n'est plus authentifié après cet appel.

Cette fonction ne prend pas d'arguments.

``public function session_id_changed()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Indique à la bibiliothèque que l'identifiant de session a changé. La fonction appelle AriseID pour mettre à jour l'information. Cette fonction est nécessaire pour permettre au Single LogOut de bien fonctionner.

Cette fonction ne prend pas d'arguments.

``static public function get_single_logout_uri($return_uri)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie l'URL où envoyer l'utilisateur pour qu'il puisse se déconnecter d'un seul coup de tous les sites clients AriseID (Single LogOut de session). L'utilisateur sera ensuite redirigé vers l'URL renseignée si il n'y a pas eu d'erreur de déconnexion. Dans le cas contraire, l'utilisateur sera informé de l'échec et invité à revenir vers l'URL.

Cette fonction prend l'argument suivant :

 * ``return_uri``: l'URL de retour vers où rediriger l'utilisateur

``static public function getScriptURL($with_query = TRUE)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Renvoie l'URL de la page actuelle. Optionnellement avec les paramètres passés en query (après le ?).

Cette fonction prend l'argument suivant :

 * ``with_query``: TRUE pour inclure la partie query dans l'URL renvoyée

``public function set_cleanup_callback($cleanup)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Indique à la bibilothèque si elle doit nettoyer l'URL une fois l'authentification réalisée pour supprimer les paramètres liés à OAuth.
Par défaut le nettoyage est effectué et une redirection supplémentaire est effectuée.

Cette fonction prend l'argument suivant :

 * ``$cleanup``: booleen indiquant si il faut effectuer le nettoyage

``OAuthAPICaller``
------------------

``public function begin()``
~~~~~~~~~~~~~~~~~~~~~~~~~~~

Active l'appel à l'API par lot. Une fois cet appel effectué, les divers appels de fonction seront mis en cache et la fonction ``done`` effectuera l'ensemble des appels en une seule requête.
Cette fonction renvoie l'instance d'``OAuthAPICaller`` utilisée pour l'appel.

Cette fonction ne prend pas d'arguments.

``public function done()``
~~~~~~~~~~~~~~~~~~~~~~~~~~

Termine une série d'appels par lot. Cette fonction renvoie un tableau contenant des foncteurs.
Chaque foncteur renverra le résultat de l'appel à l'API lorsqu'il sera appelé ou générera une exception en cas d'erreur de l'API.

Cette fonction ne prend pas d'arguments.


``public function <fonction API>(...)``
~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~~

Fonction générique qui permet de réaliser un appel à l'API.

Entre un appel à ``begin`` et un appel à ``done``, cette fonction met en cache l'appel et retourne l'instance d'``OAuthAPICaller`` utilisée pour l'appel.
En dehors de ces appels, cette fonction effectue l'appel et renvoie le résultat ou une exception en cas d'erreur.

Cette fonction prend le nombre d'arguments attendu par l'API.

OAuth pour les nuls
===================

Le standard OAuth 1.0a
----------------------

OAuth (`RFC 5849`_) fournit une méthode à des clients leur permettant d'accéder à des ressources stockées sur un serveur au nom du possesseur de la ressource (un autre client ou un utilisateur final). Il fournit aussi un moyen pour les utilisateurs finaux d'autoriser un tiers à accéder à leurs ressources stockées sur le serveur sans avoir à partager leurs identifiants de connexion (par exemple, un identifiant et un mot de passe), en utilisant des redirections côté navigateur.

De cette description librement traduite de la RFC, nous allons essayer d'expliquer qui fait quoi.

OAuth mentionne trois entités :

 * un possesseur de ressource (*resource owner*, *end-user* ou *user*) : il s'agit des élèves qui visiteront votre application,
 * un serveur (*server* ou *provider*) qui possède des données et auxquelles votre application veut accéder : dans notre cas, il s'agit de AriseID,
 * un client (*consumer*) : votre application qui voudra accéder aux données des élèves.

Le principe de OAuth est de permettre à une application d'accéder aux données d'un élève sans que celui-ci n'ait à fournir son couple identifiant/mot de passe à l'application. AriseID étant responsable de l'authentification et s'assurant de l'accord de l'utilisateur avant de transmettre les informations demandées à l'application.

Une application OAuth, pour accéder aux données de l'utilisateur, a préalablement besoin d'un couple identifiant/secret partagé qui lui sera donné par AriseID. C'est dans le chapitre `Préparation`_ qu'est expliqué comment obtenir ces informations.

Le processus d'authentification de l'utilisateur se déroule comme ceci :

 * l'élève se rend sur la page de l'application (par exemple ``http://toto.iiens.net/monapplication/``),
 * il initie une authentification en demandant à se connecter (par exemple en cliquant un bouton *Se connecter à AriseID*),
 * l'application demande à AriseID un jeton temporaire en spécifiant une URL de retour (cette tâche est effectuée par la bibilothèque OAuth et vous n'avez pas besoin de vous en préoccuper),
 * l'application redirige ensuite l'utilisateur vers ``http://oauth.iiens.net/authorize.php?token=<identifiant du token>``,
 * l'élève est invité à s'authentifier si il ne l'est pas déjà et à autoriser l'application à accéder à ses données,
 * une fois que l'élève a accepté, AriseID redirige l'élève vers l'URL renseignée dans la demande de jeton temporaire,
 * l'application utilise son jeton temporaire pour le convertir en un jeton longue durée qui lui permettra d'accéder à l'API de AriseID,
 * l'application effectue ses appels à l'API AriseID pour accéder aux ressources de l'utilisateur.

OAuth décrit les mécanismes généraux pour effectuer une authentification. Certains paramètres sont laissés au choix de l'administrateur du serveur. Charge à lui de les communiquer aux dévelopeurs des clients.
AriseID est configuré avec les paramètres suivants :

 * Temporary Credential Request : ``https://oauth.iiens.net/initiate.php``
 * Resource Owner Authorization URI : ``https://oauth.iiens.net/authorize.php``
 * Token Request URI : ``https://oauth.iiens.net/token.php``
 * Signature Method : ``HMAC-SHA1``

.. _`RFC 5849`: https://tools.ietf.org/html/rfc5849

Les spécificités ajoutées par Arise
-----------------------------------

API
~~~

Le protocole OAuth laisse aux serveurs le soin de décider comment accéder aux données une fois l'authentification réalisée.
Pour AriseID, l'accès se fait via ``http://oauth.iiens.net/api.php``. Il s'agit d'une requête :

 * avec la méthode ``POST``,
 * un header ``Content-Type: application/json``,
 * son corps contient un ou plusieurs appels `JSON-RPC 2`_,
 * les paramètres OAuth sont complétés par un paramètre ``oauth_api_call_hash`` contenant un hash SHA-256 du corps de la requête,
 * et authentifiée comme indiqué dans la RFC (le corps de la requête ne fait donc pas partie de la signature).

.. _`JSON-RPC 2`: http://www.jsonrpc.org/specification

Les méthodes fournies par AriseID sont :

 * ``get_authorizations()`` : renvoie un tableau avec toutes les autorisations accordées par l'utilisateur,
 * ``set_consumer_data($data)`` : sauvegarde une donnée fournie par le client pour utilisation ultérieure, cette donnée est associée au jeton et communiquée lors du Single LogOut,
 * ``get_consumer_data()`` : renvoie la donnée précédemment fournie par le client.

Elles sont disponibles pour tous les clients sans aucune autorisation nécessaire.

Les méthodes suivantes sont également fournies, sous réserve de demander l'autorisation :

 * ``get_identifiant()`` : Lire l'identifiant
 * ``get_nom()`` : Lire le nom de famille
 * ``get_prenom()`` : Lire le prénom
 * ``get_nom_complet()`` : Lire le nom complet
 * ``get_surnom()`` : Lire le surnom
 * ``get_sexe()`` : Lire le sexe (renvoie M ou F)
 * ``get_promotion()`` : Lire la promotion
 * ``get_naissance_date()`` : Lire la date de naissance
 * ``get_email()`` : Lire l'e-mail préféré (l'e-mail personnel si il est renseigné, l'e-mail ENSIIE sinon)
 * ``get_email_ensiie()`` : Lire l'e-mail ENSIIE
 * ``get_email_perso()`` : Lire l'e-mail personnel
 * ``get_localisation()`` : Lire la localisation (Evry = 0/Strasbourg = 1)
 * ``get_groupe()`` : Lire le groupe
 * ``get_statut_ecole()`` : Lire le statut à l'école (FI = 0/FIPA = 1)
 * ``get_statut_arise()`` : Lire le statut ARISE (1 si l'élève est adhérent Arise, 0 sinon)
 * ``get_statut_aeiie()`` : Lire le statut AEIIE (1 si l'élève est adhérent AEIIE, 0 sinon)
 * ``get_statut_compte()`` : Lire le statut du compte (TRUE si le compte est actif, FALSE sinon)
 * ``get_assoce_member()`` : Lire les associations dont l'utilisateur est membre
 * ``get_assoce_master()`` : Lire les associations dont l'utilisateur est administateur
 * ``get_assoce_owner()`` : Lire les associations dont l'utilisateur est président
 * ``get_logement_adresse()`` : Lire l'adresse postale
 * ``get_logement_appart()`` : Lire le numéro d'appartement
 * ``get_telephone_maison()`` : Lire le numéro de téléphone fixe
 * ``get_telephone_portable()`` : Lire le numéro de téléphone portable
 * ``get_site_web()`` : Lire l'adresse du site Web
 * ``get_im_icq()`` : Lire le n° ICQ
 * ``get_im_jabber()`` : Lire l'adresse Jabber
 * ``get_cv_de()`` : Lire l'URL du CV en allemand
 * ``get_cv_en()`` : Lire l'URL du CV en anglais
 * ``get_cv_fr()`` : Lire l'URL du CV en français
 * ``get_cv_file()`` : Lire l'URL du CV (fichier)
 * ``get_cv_it()`` : Lire l'URL du CV en italien
 * ``get_cv_sp()`` : Lire l'URL du CV en espagnol

Single LogOut
~~~~~~~~~~~~~

OAuth ne fournit aucune fonctionnalité de déconnexion. Pour AriseID, une fonctionnalité a été introduite. Lors de la création d'une application, une URL de déconnexion est renseignée par le développeur.
Lorsque l'utilisateur se déconnecte de l'ensemble des sites, AriseID va contacter l'ensemble des URLs de déconnexion en leur communiquant dans l'en-tête HTTP ``OAuthLogout`` le token invalidé et la donnée cliente associée.

LA bibliothèque OAuth Arise gère automatiquement le Single LogOut. Le seul pré-requis étant que ``OAuthAriseClient::getInstance`` soit appelé dans le code exécuté lors de la requête de logout.
