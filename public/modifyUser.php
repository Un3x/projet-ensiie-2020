<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
include_once "errors.php";

/*******/
/*this file is used by the user to change its account settings, 
 * the new settings are send to Forms/modifyUserAccout.php
 *******/
?>

<?php include_once "View/Layout/head.php" ?>
</head>
<?php include_once "View/Layout/header.php"?>

<?php
if ( !isset($_SESSION['id']) )
{
    connect_yourself();
    exit();
}
?>

<body>
<?php include_once "View/Layout/modifyUser.php" ?>

</body>
</html>




