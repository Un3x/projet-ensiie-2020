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

$dbAdapter = (new DbAdaperFactory())->createService();
$playlistRepository = new \Playlist\PlaylistRepository($dbAdapter, $_SESSION['id']);
$ownplaylists = $playlistRepository->fetchAllOf($_SESSION['id']);
$allplaylists = $playlistRepository->fetchAllPublik();

?>

<h2>All public playlists:</h2>
<div id="publikPlaylists">
    <ul>
        <?php foreach ($allplaylists as $playlist): ?>
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
