<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";
?>

<?php include_once "View/Layout/head.php" ?>
<link rel="stylesheet" type="text/css" href="/styles/playlist.css?v=1.0">
</head>

<?php include_once "View/Layout/header.php" ?>

<body>
<?php
if ( !isset($_SESSION['id']) )
{
    connect_yourself();
    exit();
}
?>

<?php
if ( isset($_GET['create']) && $_GET['create'] === "success" )
{
    echo '<p class="feedback">New playlist successfully created!</p>';
}
?>

<p>To create a playlist, it's <a href="/playlists/createPlaylist.php">this way</a></p>

<?php include_once "View/Layout/ownPlaylistList.php" ?>

<?php include_once "View/Layout/publikPlaylistList.php" ?>

</body>
</html>