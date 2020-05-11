<?php
session_start();

if ( !(isset($_SESSION['id'])) )
{
    echo '<div class="error"> Veuillez <a href="/login.php">vous connecter</a> pour accéder aux playlists</div>';
    exit();
}

include_once 'Playlist/Playlist.php';
include_once 'Playlist/PlaylistRepository.php';
include_once 'Factory/DbAdaperFactory.php';

if ( !isset($dbAdapter) )
    $dbAdapter = (new DbAdaperFactory())->createService();
if ( !isset($playlistRepository) )
    $playlistRepository = new \Playlist\PlaylistRepository($dbAdapter);
$allplaylists = $playlistRepository->fetchAllPublik();

?>

<h2>All public playlists:</h2>
<div id="publikPlaylists">
    <ul>
        <?php foreach ($allplaylists as $playlist): ?>
            <li id="aPlaylistInPublikList">
                <form action="/playlists/modifyPlaylist.php" method="GET">
                <input name="playlist_id" value="<?= $playlist->getId()?>" hidden>
                <button type="submit">Modify</button>
                </form>
                <form action="/playlists/deletePlaylist.php" method="POST">
                <input name="playlist_id" value="<?= $playlist->getId()?>" hidden>
                <button type="submit">Delete</button>
                </form>
                <form action="/playlists/importPlaylistIntoQueue.php" method="POST">
                <input name="playlist_id" value="<?= $playlist->getId()?>" hidden>
                <button type="submit">Add to queue</button>
                </form>
                <span><?= $playlist->getName()?></span>
                <div id=PlaylistInfo_<?= $playlist->getId()?> style="display: none">
                </div>
            </li>
        <?php endforeach; ?>
    </ul>
</div>
