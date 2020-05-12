<?php
session_name("sessionutilisateurdusitespotifiie");
// ne pas mettre d'espace dans le nom de session !
session_start();
if (!isset($_SESSION['initiated'])) {
    session_regenerate_id();
    $_SESSION['initiated'] = true;
}
// Décommenter la ligne suivante pour afficher le tableau $_SESSION pour le debuggage
require('affichage/utils.php');
require('adoDB/adoDB.php');
require('adoDB/utilisateur.php');
require('adoDB/musique.php');
require('adoDB/playlist.php');
require ('adoDB/commentaire.php');
require('affichage/affichageDB.php');
require('affichage/printForms.php');
require('adoDB/logInOut.php');
$dbh =(new Database())->createService();
//demarre la base de donnees
// traitement des contenus de formulaires
if (array_key_exists('todo', $_GET)) {
    $todo = $_GET["todo"];
    if ($todo == "login") {
        // connecte l'utilisateur
        logIn($dbh);
    }
    if ($todo == "logout") {
        // deconnecte l'utilisateur
        logOut($dbh);
    }
    if ($todo == "register") {
        // enregistre un nouvel utilisateur
        register($dbh);
    }
    if ($todo == "refreshVerticalMenu") {
        $liste_playlists = Playlist::mesPlaylists($dbh);
        echo '<div id = verticalMenu>';
        echo '<ul class="navbar-nav flex-column">';
        echo '<li class = "nav-item"><span style="color: white">Mes playlists</span>';
        for ($i = 0; $i < count($liste_playlists); ++$i) {
            echo '<li class="nav-item" style="margin-left:10px">';
            echo "  <a class='nav-link playlist' href='#' id=" . $liste_playlists[$i]->id . ">" . $liste_playlists[$i]->titre . "<span class='sr-only'>(current)</span></a>";
            echo '</li>';
        }
        echo <<<_FIN
    <li class="nav-item">
    <a class='nav-link' href='#' id='nouvelle_playlist'>Nouvelle playlist<span class='sr-only'>(current)</span></a>
    </li>
	</li>
   </ul>
   </div>
_FIN;
        exit(0);
    }
    if ($todo == "affichernouveautes") {
        echo'<img src="images_playlists/7.jpg" id="banniere">';
        require("content/content_nouveautes.php");
        exit(0);
    }
    if ($todo == "ma_musique") {
        require("content/content_page_playlist.php");
    }
    if ($todo == "rechercher") {
        //affiche le resultat d'une recherche
        require("content/content_page_recherche.php");
    }
    if ($todo == "change_musique") {
        //change de musique avec celle precisee
        require("todo/change_musique.php");
    }

    if ($todo == "musique_suivante") {
        //choisit la musique suivante (selon que l'on soit en mode : playlist, single ou replay ...)
        require("todo/musique_suivante.php");
    }

    if ($todo == "afficherplaylist") {
        //affiche les musiques d'une playlist
        $id_playlist = $_REQUEST['idplaylist'];
        //echo '<img src="images_playlists/8.jpg" style="width: 100%;height: auto;">';
        afficherPagePlaylist(Playlist::getInfoPlaylist($dbh, $id_playlist), Playlist::ListeMusiquesDansPlaylist($dbh, $id_playlist));
        exit(0);
    }


    if ($todo == "afficherplaylistasso") {
        //affiche la playlist d'un asso
        $asso = $_REQUEST['asso'];
        afficherPagePlaylistAsso($asso, Musique::ListeMusiquesAsso($dbh, $asso));
        exit(0);
    }

    if ($todo == "affichernouvelleplaylist") {
        //affiche les musiques d'une playlist
        require("content/content_nouvelle_playlist.php");
    }

    if ($todo == "affichermusique") {
        //affiche la page d'infos d'une musique
        $id_musique = $_REQUEST['musique'];
        afficherPageMusique(Musique::getInfoMusique($dbh, $id_musique), Commentaire::getCommentaires($dbh, $id_musique));
        exit(0);
    }

    if ($todo == "ajout_playlist") {
        //affiche la popup d'ajout d'une musique à une playlist
        $id_musique = $_REQUEST['musique'];
        $liste_playlists = Playlist::mesPlaylists($dbh);
        echo '<label for="liste_playlists">Choisir playlist : </label>';
        echo '<select id="liste_playlists">';
        for ($i = 0; $i < count($liste_playlists); ++$i) {
            echo "<option value=" . $liste_playlists[$i]->id . ">";
            echo $liste_playlists[$i]->titre;
            echo "</option>";
        }
        echo "<input id=" . $id_musique . " class='btn btn-outline-success my-2 my-sm-0 valider_ajout_playlist' value='Valider' />";
        exit(0);
    }

    if ($todo == "valider_ajout_playlist") {
        //valide l'ajout de la musique à la playlist
        $id_musique = $_REQUEST['musique'];
        $id_playlist = $_REQUEST['playlist'];
        $reussi = Playlist::insererMusiqueDansPlaylist($dbh, $id_playlist, $id_musique);
        if ($reussi) {
            echo '<p>Musique ajoutée avec succès !</p>';
        } else {
            echo '<p>La musique est déjà présente dans la playlist.</p>';
        }
        exit(0);
    }

    if ($todo == "valider_nouvelle_playlist") {
        //valide la creation de la nouvelle playlist
        $titre_playlist = $_POST['titre'];
        $reussi = Playlist::insererPlaylist($dbh, $titre_playlist);
        exit(0);
    }

    if ($todo == "playplaylist") {
        //joue une playlist (passe en mode playlist)
        require("todo/playplaylist.php");
    }

    if ($todo == "deleteplaylist") {
        //joue une playlist (passe en mode playlist)
        $id_playlist = $_GET['playlist'];
        $reussi = Playlist::deletePlaylist($dbh, $id_playlist);
        echo "<h2>Playlist supprimée avec succès.</h2>";
        exit(0);
    }

    if ($todo == "deletemusique") {
        //joue une playlist (passe en mode playlist)
        $id_musique = $_GET['musique'];
        $id_playlist = $_REQUEST['playlist'];
        $reussi = Playlist::deleteMusiqueFromPlaylist($dbh, $id_playlist, $id_musique);
        //echo '<img src="images_playlists/8.jpg" style="width: 100%;height: auto;">';
        afficherPagePlaylist(Playlist::getInfoPlaylist($dbh, $id_playlist), Playlist::ListeMusiquesDansPlaylist($dbh, $id_playlist));
        exit(0);
    }

    if ($todo == "playplaylistasso") {
        //joue une playlist (passe en mode playlist)
        require("todo/playplaylistasso.php");
    }

    if ($todo == "poster_commentaire") {
        //ajoute un commentaire
        $id_musique = $_GET['musique'];
        $texte = $_POST['texte'];
        Commentaire::insererCommentaire($dbh, $id_musique, $texte);
        exit(0);
    }
}

if (array_key_exists('page', $_GET)) {
    $askedPage = $_GET['page'];
} else {
    $askedPage = "accueil";
}

$authorized = checkPage($askedPage);

if ($authorized) {
    $pageTitle = getPageTitle($askedPage);
} else {
    $pageTitle = "ERREUR 404 NOT FOUND";
}
generateHTMLHeader($askedPage, "css/perso.css");

if (isset($_SESSION["loggedIn"])) {
    $connecte = True;
} else {
    $connecte = False;
}
?>
<body>

    <header class="navbar navbar-expand-lg navbar-dark bg-dark sticky-top" >
<?php
$assos = getAssos($dbh);
generateMenu($connecte, $askedPage, $assos);
?>
    </header>
        <?php
        if ($connecte) {
            require("content/content_connecte.php");
        } else {
            require("content/content_deconnecte.php");
        }
        ?>

    <?php
    generateHTMLFooter();
    