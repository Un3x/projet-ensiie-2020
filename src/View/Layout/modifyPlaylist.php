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
    $playlist_id = htmlspecialchars($_GET['playlist_id']);
    $playlist_all = $playlistRepository->fetchPlaylist($playlist_id, $_SESSION['id']);
    $playlist = $playlist_all[0];
    $karas = $playlist_all[1];
}

catch ( Exception $e )
{
    echo "Error : " . $e->getMessage();
}

catch ( PDOException $err )
{
    header('Location /error.php?error=sqlerror');
    exit();
}
?>

<h1>Gestion de vos playlists :</h1></br>

<h3>Playlist : <?= $playlist->getName()?></h3>
<p>Id: <?= $playlist->getId()?></p>

<div id="karaList">
    <ul>
        <?php foreach ($karas as $kara): ?>
            <form method="POST" action="/playlists/deleteKara.php">
                <li id="aKaraInKaraList">
                    <input name="playlist_id" value="<?= $playlist->getId()?>" hidden>
                    <input name="kara_id" value="<?= $kara->getId()?>" hidden>
                    <button type="submit">Delete</button>
                    <button type="button" onclick="toggleKaraInfo(<?= $kara->getId()?>)">Infos</button>
                    <span><?= $kara->getString()?></span>
                    <div id=KaraInfo_<?= $kara->getId()?> style="display: none">
                        <h3>Infos</h3>
                        <ul>
                            <li>Source Name : <?= $kara->getSourceName()?></li>
                            <li>Song Name : <?= $kara->getSongName()?></li>
                            <li>Category : <?php    echo $kara->getCategory();
                                                    echo $kara->getSongNumber();?></li>
                            <li>Author Name : <?= $kara->getAuthorName()?></li>
                            <li>Language : <?= $kara->getLanguage()?></li>
                            <li>ID : <?= $kara->getID()?></li>
                        </ul>
                    </div>
                </li>
            </form>
        <?php endforeach; ?>
    </ul>
</div> 
<script src="/scripts/karaList.js"></script>
