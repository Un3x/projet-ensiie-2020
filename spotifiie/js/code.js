
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$(document).on('click', 'div#content .play', function (){
    $("#container_player").load("index.php?todo=change_musique&musique=" + $(this).attr('id'));
});

$(document).on('click', '.playlist', function () {
    $("#content").load("index.php?todo=afficherplaylist&idplaylist=" + $(this).attr('id'));
});

$(document).on('click', '#nouvelle_playlist', function () {
    $("#dialog").load("index.php?todo=affichernouvelleplaylist");
        $("#dialog").dialog("open");
});

$(document).on('click', 'div#content .add', function () {
    $("#dialog").load("index.php?todo=ajout_playlist&musique=" + $(this).attr('id'));
    $("#dialog").dialog("open");
});

$(document).on('click', 'div#content .playlist_play', function () {
    $("#container_player").load("index.php?todo=playplaylist&playlist=" + $(this).attr('id'));
});

$(document).on('click', 'div#content .playlistasso_play', function () {
    $("#container_player").load("index.php?todo=playplaylistasso&asso=" + $(this).attr('id'));
});

$(document).on('click', 'div#dialog .valider_ajout_playlist', function () {
    $("#dialog").load("index.php?todo=valider_ajout_playlist&musique=" + $(this).attr('id') + "&playlist=" + $("#liste_playlists").val());
$("#dialog").dialog("open");
});

$(document).on('click', 'div#dialog .valider_nouvelle_playlist', function () {
    $("#nothing").load("index.php?todo=valider_nouvelle_playlist", {
        titre: $("#titre_playlist").val()
    });
    $("#verticalMenuFrame").load("index.php?todo=refreshVerticalMenu");
    $("#dialog").dialog("close");
});

$(document).on('click', 'div#content .playlist_delete', function () {
    $("#content").load("index.php?todo=deleteplaylist&playlist=" + $(this).attr('id'));
    $("#verticalMenuFrame").load("index.php?todo=refreshVerticalMenu");
});

$(document).on('click', 'div#content .musique_delete', function () {
    $("#content").load("index.php?todo=deletemusique&musique=" + $(this).attr('id')+"&playlist="+$(".playlist_play").attr('id'));
});


$(document).on('click', 'div#content a.asso', function () {
    $("#content").load("index.php?todo=afficherplaylistasso&asso=" + $(this).attr('id'));
});

$(document).on('click', 'div#content a.lienmusique', function () {
    $("#content").load("index.php?todo=affichermusique&musique=" + $(this).attr('id'));
});

$(document).on('click', 'div#content .poster_commentaire', function () {
    $("#nothing").load("index.php?todo=poster_commentaire&musique=" + $(this).attr('id'), {
        texte: $("#commentaire").val()
    });
    $("#content").load("index.php?todo=affichermusique&musique=" + $(this).attr('id'));
});


$(document).ready(function () {
    $("#dialog").dialog({autoOpen: false});

    $("#rechercher").click(function () {
        $("#content").load("index.php?todo=rechercher&recherche=" + $("#rechercher_container").val());
    });

    $("#ma_musique").click(function () {
        $("#content").load("index.php?todo=ma_musique");
    });
    
    $(".asso").click(function () {
        $("#content").load("index.php?todo=afficherplaylistasso&asso=" + $(this).attr('id'));
    });
    
    $("#spotifiie").click(function () {
        $("#content").load("index.php?todo=affichernouveautes");
    });
});

