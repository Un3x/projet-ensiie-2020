<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
?>

<?php
include_once "View/Layout/head.php" ?>
</head>

<body>
<?php include_once "View/Layout/gestionPlaylist.php" ?>

</body>
</html>