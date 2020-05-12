<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

if ( isset($_SESSION['id']) )
{
require_once 'Factory/DbAdaperFactory.php';
require_once 'Playlist/PlaylistRepository.php';

if ( !isset($dbAdapter) )
    $dbAdapter = (new DbAdaperFactory())->createService();
if ( !isset($playlistRepository) )
    $playlistRepository = new \Playlist\PlaylistRepository($dbAdapter);

try 
{
    $playlistId = htmlspecialchars($_POST['playlist_id']);
    $playlistRepository->deletePlaylist($playlistId, intval($_SESSION['id']));
}
catch ( Exception $e )
{
    echo "Error : " . $e->getMessage();
    exit();
}

catch ( PDOException $err )
{
    header('Location: /error.php?error=sqlerror');
    exit();
}

header('Location: /playlists/playlists.php');


}

else
{
    echo "I'm gonna pay you $100 to fuck off.";
}
?>
