<?php

/* On inclut la bibliothèque Arise pour OAuth. */
/* ======================= ATTENTION ! ======================== */
/* Ce fichier doit être inclut AVANT un appel à session_start() */

require_once("../src/OAuth2/ariseid/client/OAuthAriseClient.php");

/*
Le fichier config.inc.php contient les informations d'identifications.
Elles sont à garder précieusement : attention aux droits du fichier !
*/

require_once("../src/OAuth2/keys.php");

$consumer = OAuthAriseClient::getInstance(
    $consumer_key,
    $consumer_secret,
    $consumer_private_key
);

if (isset($_POST['login'])) {
    $consumer->authenticate();
}

if (isset($_POST['logout'])) {
    $consumer->logout();
    include_once("logout.php");
}

if ($consumer->has_just_authenticated()) {
    session_regenerate_id();
    $consumer->session_id_changed();
}

if ($consumer->is_authenticated()) {
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
  ->get_surnom()
  ->get_prenom()
  ->get_nom()
  ->get_assoce_member()
  ->get_assoce_master()
  ->get_assoce_owner()
  ->done();

    /*
    Nous accédons au résultat en faisant un appel : ``$result[0]``
    correspond à un résultat et nous l'appelons : ``$result[0]()``.
    Cet appel générera une exception si Arise a renvoyé une erreur
    lors de l'appel. Sinon, la valeur de retour est le résultat
    de l'appel que nous affichons ici.
    */

    try {
        if (isset($_SESSION)) {
            $id = $results[0]();
            $pseudo = $results[1]();
            $prenom = $results[2]();
            $nom = $results[3]();
            $assoceMember = $results[4]();
            $assoceMaster = $results[5]();
            $assoceOwner = $results[6]();
            $role = "iien";
            if (in_array("vocaliise", $assoceMember)) {
                $role = "membre";
            }
            if (in_array("vocaliise", $assoceMaster)) {
                $role = "admin";
            }
            if (in_array("vocaliise", $assoceOwner)) {
                $role = "admin";
            }

            include_once '../src/Model/Factory/dbFactory.php';
            $dbAdapter = (new dbFactory())->createService();

            $sql = <<<SQL
            INSERT INTO utilisateur (id, pseudo, prenom, nom, role_utilisateur)
            VALUES (:id, :pseudo, :prenom, :nom, :role)
            ON CONFLICT (id) DO UPDATE
            SET pseudo = excluded.pseudo, prenom = excluded.prenom, nom = excluded.nom, role_utilisateur = excluded.role_utilisateur
  SQL;
            $result = $dbAdapter->prepare($sql);
            $result->bindValue(':id', $id, PDO::PARAM_STR);
            $result->bindValue(':pseudo', $pseudo, PDO::PARAM_STR);
            $result->bindValue(':prenom', $prenom, PDO::PARAM_STR);
            $result->bindValue(':nom', $nom, PDO::PARAM_STR);
            $result->bindValue(':role', $role, PDO::PARAM_STR);

            $result->execute();

            $_SESSION["Id"] = $id;
            include_once("login.php");
        }
    } catch (OAuthAPIException $e) {
        echo "Erreur : ".$e->getMessage();
    } ?>

  <form method="post">
    <input type="submit" name="logout" value="D&eacute;connexion"/>
  </form>
  <a href="<?php echo $consumer->get_single_logout_uri(
        OAuthAriseClient::getScriptURL()
    ) ?>">
    D&eacute;connexion de AriseID
  </a>
  <?php
}
?>
