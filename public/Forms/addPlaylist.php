<?php
//******
//This page is used for adding a new playlist to the database, after checking if the infos are correct.
//File called by createPlaylist.php
//what to add: getting the user)
//*****
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
session_start();
use Playist\PlaylistRepository;

include 'Playlist/Playlist.php';
include 'Playlist/PlaylistRepository.php';
include 'Factory/DbAdaperFactory.php';

$errsCount=0;
$dbAdaper = (new DbAdaperFactory())->createService();
$playlistRepository = new PlaylistRepository($dbAdaper);

$name   = htmlspecialchars($_POST['name']);
$publik = htmlspecialchars($_POST['publik']);
$creator= $_SESSION['username'];

//check validity of given name

if ($name=='')
{
    header("Location: ../createPlaylist.php?errs=noName");
    exit();
}
elseif ($playlistRepository->checkPlaylist($name,$creator)>0){ //check if user already has a playlist with this name exist
    header("Location: ../createPlaylist.php?errs=usedName");
    exit();
}

?>