<?php
$playlist = Playlist::getPlaylist($dbh, "favoris");
if($playlist === NULL)
{
    echo '<h2>Vous avez supprimé "Ma musique"</h2>';
}
else
{
    $id = $playlist->id;
afficherPagePlaylist($playlist, Playlist::ListeMusiquesDansPlaylist($dbh, $id));
}
exit(0);


