<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');


?>

<?php include_once "View/Layout/head.php" ?>
<link rel="stylesheet" type="text/css" href="/styles/karaList.css?v=1.0">
<link rel="stylesheet" type="text/css" href="/styles/karaQueue.css?v=1.0">
</head>


<body>
<?php include_once "View/Layout/header.php" ?>

<?php include_once "View/Layout/karaQueue.php" ?>

<?php include_once "View/Layout/karaList.php" ?>

<script src="/scripts/scripts.js"></script>
</body>
</html>
