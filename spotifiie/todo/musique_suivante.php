<?php

if ($_SESSION["ecoute"] === "single") {
    // On ne fait rien, c'etait une ecoute simple
    $musique = $_SESSION['enCours'];
    $play = false;
}
if ($_SESSION["ecoute"] === "replay") {
    // On ne fait rien, c'etait une ecoute simple
    $musique = $_SESSION['enCours'];
    $play = true;
}
if ($_SESSION["ecoute"] === "playlist") {
    // On passe à musique suivante de la playlist
    $i = $_SESSION['indice_dans_liste'] + 1;
    if ($i < count($_SESSION['liste_musiques'])) {
        $musique = $_SESSION['liste_musiques'][$i];
        $_SESSION['indice_dans_liste'] = $i;
    } else {
        $musique = $_SESSION['liste_musiques'][0];
        $_SESSION['indice_dans_liste'] = 0;
    }
    $play = true;
}
$_SESSION['enCours'] = $musique;
$image = "images_musiques/" . $musique . ".jpg";
if (!file_exists($image)) {
    $image = "images_musiques/" . $musique . ".png";
    if (!file_exists($image)) {
        $image = "images/ado.jpg";
    }
}
echo "<img src=" . $image . " id='imagePlayer'>";
echo '<audio id="player" controls="controls" style="width:100%">';
echo "<source  src='musiques/" . $musique . ".mp3' type='audio/mp3' />";
echo "</audio>";
echo "<script>";
echo "var player = document.getElementById('player');";
if ($play) {
    echo "player.play();";
}
echo "player.onended = function(){";
echo "$('#container_player').load('index.php?todo=musique_suivante');";
echo "};";
echo "</script>";
exit(0);

