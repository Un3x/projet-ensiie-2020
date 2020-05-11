<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include 'Playlist/Playlist.php';
include 'Playlist/PlaylistRepository.php';
include 'Factory/DbAdaperFactory.php';


if ( !isset($dbAdapter) )
    $dbAdapter = (new DbAdaperFactory())->createService();
if ( !isset($playlistRepository) )
    $playlistRepository = new \Playlist\PlaylistRepository($dbAdapter);

try
{
    $playlist = $playlistRepository->fetchPlaylist($id, $userId);
}
catch (PDOException $err)
{
    header('Location /error.php?error=sqlerror');
    exit();
}


?>

<h1>Gestion de vos playlists :</h1></br>
<?php


