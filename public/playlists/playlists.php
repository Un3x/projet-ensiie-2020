<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
?>

<?php include_once "View/Layout/head.php" ?>
</head>

<?php include_once "View/Layout/header.php" ?>

<body>

<?php
if ( isset($_GET['create']) && $_GET['create'] === "success" )
{
    echo '<p class="feedback">New playlist successfully created!</p>';
}
?>

<?php include_once "View/Layout/ownPlaylistList.php" ?>

<?php include_once "View/Layout/publikPlaylistList.php" ?>

</body>
</html>
