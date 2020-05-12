<?php

$asso = $_REQUEST['asso'];
$_SESSION['ecoute'] = 'playlist';
$_SESSION['indice_dans_liste'] = 0;
$tab = Musique::ListeMusiquesAsso($dbh, $asso);
$liste_musiques = array();
$c = count($tab);
if ($c > 0) {// si la playlist n'est pas vide on la lance
    for ($i = 0; $i < count($tab); ++$i) {
        array_push($liste_musiques, $tab[$i]->id);
    }
    $_SESSION['liste_musiques'] = $liste_musiques;
    $musique = $_SESSION['liste_musiques'][0];
    $_SESSION['enCours'] = $musique;
    $play = true;
} else {
    $musique = $_SESSION['enCours'];
    $play = false;
}
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

