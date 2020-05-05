<?php
include_once 'Karas/Kara.php';
include_once 'Karas/KaraRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdapter = (new DbAdaperFactory())->createService();
$karaRepository = new \Kara\KaraRepository($dbAdapter);
$karas = $karaRepository->fetchAll();
$playlistRepository = new \Playlist\PlaylistRepository($dbAdapter, $_SESSION['id']);$playlists = $playlistRepository->fetchAll();
?>
