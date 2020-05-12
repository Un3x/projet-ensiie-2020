<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";
?>


<?php
include_once "View/Layout/head.php" ?>
<link rel="stylesheet" type="text/css" href="/styles/karaList.css?v=1.0">
</head>

<?php include_once "View/Layout/header.php";?>

<body>
<?php
if ( !isset($_SESSION['id']) )
{
    connect_yourself();
    exit();
}
?>

<?php include_once "View/Layout/peekPlaylist.php" ?>

</body>
</html>
