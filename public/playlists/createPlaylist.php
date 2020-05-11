<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";
?>

<?php include_once "View/Layout/head.php" ?>
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

<?php include_once "View/Layout/createPlaylist.php" ?>

</body>
</html>
