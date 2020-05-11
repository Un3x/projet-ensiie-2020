<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
?>

<?php include_once "View/Layout/head.php" ?>
</head>

<?php include_once "View/Layout/header.php" ?>

<body>
<?php include_once "View/Layout/registration.php" ?>

</body>
</html>
