<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');


?>

<?php include_once "View/Layout/head.php" ?>


<body>
<?php include_once "View/Layout/header.php" ?>

<?php include_once "View/Layout/karaQueue.php" ?>

<?php include_once "View/Layout/karaList.php" ?>

<script src="/scripts/scripts.js"></script>
</body>
</html>
