<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";


if ( isset($_SESSION['id']) && ( $_SESSION['rights'] === 1 || $_SESSION['rights'] === 2 ) )
{
    require_once 'Playlist/Playlist.php';
    require_once 'Playlist/PlaylistRepository.php';
    require_once 'Factory/DbAdaperFactory.php';

if ( !isset($dbAdapter) )
    $dbAdapter = (new DbAdaperFactory())->createService();
if ( !isset($playlistRepository) )
    $playlistRepository = new \Playlist\PlaylistRepository($dbAdapter);

try
{
    $plId = htmlspecialchars($_POST['playlist_id']);
    $playlistRepository->importPlaylistToQueue($plId, $_SESSION['id']);
}
catch ( PDOException $err )
{
    header('Location: /error.php?error=sqlerror');
    exit();
}

header('Location: /index.php');
}

else
{
    echo "You're not authorized to do this";
}

?>
