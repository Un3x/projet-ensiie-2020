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
$ownplaylists = $playlistRepository->fetchAllOf($_SESSION['id']);

?>

<h2>Your playlists:</h2>
<div id="ownPlaylists">
    <ul>
        <?php foreach ($ownplaylists as $playlist): ?>
            <form method="GET">
                <li id="aPlaylistInPublikList">
                    <button type="button" onclick="togglePlaylistInfo(<?= $playlist->getId()?>">Details</button>
                    <span><?= $playlist->getName()?></span>
                    <div id=PlaylistInfo_<?= $playlist->getId()?> style="display: none">
                    </div>
                </li>
            </form>
        <?php endforeach; ?>
    </ul>
</div>
<script src="/scripts/playlistPublikList.js"></script>
