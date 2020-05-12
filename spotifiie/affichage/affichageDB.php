<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

function afficherMusiques($liste_musiques, $delete = false) {
    echo <<<CHAINE_DE_FIN
    <table id="liste_musiques" class="display" style="width:100%">
        <thead>
            <tr>
                <th>Titre</th>
                <th>Assos</th>
                <th>Auteur</th>
                <th>Date</th>
                <th>Année </th>
                <th></th>
                <th></th>
            </tr>
        </thead>
        <tbody>
CHAINE_DE_FIN;
    for ($i = 0; $i < count($liste_musiques); ++$i) {
        echo "<tr>";
        echo "<td><a class='lienmusique' id=" . $liste_musiques[$i]->id . " href='#'>" . $liste_musiques[$i]->titre . "</a></td>";
        echo "<td><a class='asso' id=" . $liste_musiques[$i]->asso . " href='#'>" . $liste_musiques[$i]->asso . "</a></td>";
        echo "<td>" . $liste_musiques[$i]->auteur . "</td>";
        echo "<td>" . $liste_musiques[$i]->date_ajout . "</td>";
        echo "<td>" . $liste_musiques[$i]->annee_ado . "</td>";
        echo "<td><button class='play' id='" . $liste_musiques[$i]->id . "'><img src='images/play.png'></button></td>";
        echo "<td><button class='add' id='" . $liste_musiques[$i]->id . "'><img src='images/add.png'></button></td>";
        if ($delete) {
            echo "<td><button class='musique_delete' id='" . $liste_musiques[$i]->id . "'><img src='images/poubelle.png' style='height:30px'></button></td>";
        }
        echo "</tr >";
    }
    echo <<<CHAINE_DE_FIN
    </tbody>
    </table>
        <script>
        var myTable = $('#liste_musiques').dataTable({
        "searching": false,
        "ordering": false,
        "language": {
            "lengthMenu": "Afficher _MENU_ musiques par page",
            "zeroRecords": "Aucune musique ne correspond à votre recherche.",
            "info": "Page _PAGE_ sur _PAGES_",
            "infoEmpty": "Aucune musique ne correspond à votre recherche.",
            "infoFiltered": "(filtré parmi _MAX_ musiques)"
        }
    }); 
        
    $( "#draggable" ).draggable();
$( "#droppable" ).droppable({
  drop: function() {
    alert( "dropped" );
  }
});
        </script>
        
CHAINE_DE_FIN;
    return true;
}

function afficherPageMusique($musique, $liste_commentaires) {
    echo '<img src="images_playlists/7.jpg" id="banniere">';
    echo "<blockquote><h3>" . $musique->titre . "</h3>";
    echo "<button class='playlist_play' id='" . $musique->id . "'><img src='images/play.png'></button><br>";
    echo "<small>" . $musique->auteur . ", " . $musique->date_ajout . ", " . $musique->asso . ", " . $musique->annee_ado . "</small>";

    afficherCommentaires($liste_commentaires, $musique->id);
}

function afficherPagePlaylist($playlist, $liste_musiques) {
    echo '<img src="images_playlists/7.jpg" id="banniere">';
    echo "<blockquote><h3>" . $playlist->titre . "</h3>";
    echo "<button class='playlist_play' id='" . $playlist->id . "'><img src='images/play.png'></button>";
    echo "<button class='playlist_delete' id='" . $playlist->id . "'><img src='images/poubelle.png' style='height:30px'></button><br>";
    echo "<small>" . $playlist->auteur . ", " . $playlist->date_creation . "</small>";
    echo "</blockquote>";
    afficherMusiques($liste_musiques, true);
}

function afficherPagePlaylistasso($asso, $liste_musiques) {
    $image = "images_assos/" . $asso . ".jpg";
    if (!file_exists($image)) {
        $image = "images_assos/" . $asso . ".png";
        if (!file_exists($image)) {
            $image = "images_playlists/7.jpg";
        }
    }
    echo "<img src=" . $image . " id='banniere'>";
    echo "<h3>" . $asso . "</h3>";
    echo "<button class='playlistasso_play' id='" . $asso . "'><img src='images/play.png'></button>";
    afficherMusiques($liste_musiques);
}

function afficherCommentaires($liste_commentaires, $id_musique) {
    echo "<h2>COMMENTAIRES</h2>";
    $c = count($liste_commentaires);
    if ($c > 0) {
        for ($i = 0; $i < $c; ++$i) {

            echo "<blockquote>" . $liste_commentaires[$i]->texte . "<br>";
            echo "<small>" . $liste_commentaires[$i]->auteur . ", " . $liste_commentaires[$i]->date_ajout . "</small>";
            echo "</blockquote>";
        }
    } else {
        echo "<p>Aucun commentaire</p>";
    }

    echo '<div>';
    echo "<textarea name='comment' rows='3' id='commentaire' class='form-control' type='text' placeholder='Un très gentil commentaire' required></textarea>";
    echo "<div style='text-align:right'>";
    echo "<button class='btn btn-primary btn-sm poster_commentaire' id=" . $id_musique . ">Poster</button>";
    echo "</div>";
    echo "</div>";
}
