<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";


include_once "Playlist/Playlist.php";
include_once "Playlist/PlaylistRepository.php";

?>


<?php
include_once "View/Layout/head.php" ?>
</head>

<body>
<?php
if ( !isset($_SESSION['id']) )
{
    connect_yourself();
    exit();
}
?>

<?php include_once "View/Layout/gestionPlaylist.php" ?>

</body>
</html>
