<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

/*******/
/*this file is used by the user to change its account settings, 
 * the new settings are send to Forms/modifyUserAccout.php
 *******/
?>

<?php include_once "View/Layout/head.php" ?>
</head>

<body>
<?php include_once "View/Layout/modifyUser.php" ?>

</body>
</html>




