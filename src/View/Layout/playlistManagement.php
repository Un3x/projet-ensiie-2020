<?php
session_start();

if ( !(isset($_SESSION['id'] )
{
    echo '<div class=\"error\"> Veuillez <a href="/login.php">vous connecter</a> pour accéder aux playlists</div>';
    exit();
}

include_once 'Playlist/Playlist.php';
include_once 'Playlist/PlaylistRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();
$playlistRepository = new \Playlist\PlaylistRepository($dbAdapter, $_SESSION['id']);$playlists = $playlistRepository->fetchAll();
?>
