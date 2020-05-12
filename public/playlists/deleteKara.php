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
    $karaId = htmlspecialchars($_POST['kara_id']);
    $playlistRepository->deleteKaraFromPlaylist($playlistId, $karaId, intval($_SESSION['id']));
}
catch ( Exception $e )
{
    echo "Error : " . $e->getMessage();
}

catch ( PDOException $err )
{
    header('Location: /error.php?error=sqlerror');
    exit();
}

header('Location: /playlists/modifyPlaylist.php?playlist_id=' . $_POST['playlist_id']);


}

else
{
    echo "I'm gonna pay you $100 to fuck off.";
}
?>
