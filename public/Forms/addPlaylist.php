<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

require_once 'Playlist/Playlist.php';
require_once 'Playlist/PlaylistRepository.php';
require_once 'Factory/DbAdaperFactory.php';

if ( !isset($_SESSION['id']) )
{
    echo '<div class=\"error\"> Veuillez <a href="/login.php">vous connecter</a> pour accéder aux playlists</div>';
    exit();
}

$dbAdapter = (new DbAdaperFactory())->createService();
$playlistRepository = new \Playlist\PlaylistRepository($dbAdapter);

$name = htmlspecialchars($_POST['name']);
if ( $name === '' ) 
    header("Location: /playlists/createPlaylist.php?errs=wrongName&name=" . $_POST['name']);
if ( strlen($name)>127 ) 
    header("Location: /playlists/createPlaylist.php?errs=tooLongName&name=" . $_POST['name']);

$publik = htmlspecialchars($_POST['publik']);
if ( $publik === "TRUE" )
    $publik = true;
else
    $public = false;

$creator = $_SESSION['id'];

if ( $playlistRepository->createPlaylist($name, $creator, $publik) === true )
    header("Location: /playlists/playlists.php?create=success");
else
    header("Location: /playlists/createPlaylist.php?errs=fail&name=" . $_POST['name'] . "&publik=" . $_POST['publik']);
?>
