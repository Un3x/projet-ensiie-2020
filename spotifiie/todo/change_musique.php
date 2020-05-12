<?php

$musique = $_REQUEST['musique'];
$_SESSION['ecoute'] = 'single';
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
echo "player.play();";
echo "player.onended = function(){";
echo "$('#container_player').load('index.php?todo=musique_suivante');";
echo "};";
echo "</script>";
exit(0);

