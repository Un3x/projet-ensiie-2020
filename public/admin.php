<?php
session_start();

if ( !isset($_SESSION['id']) )
{
    echo "Please get out of here and nobody will get harm.";
    exit();
}

elseif ( !(($_SESSION['rights'] === 1) || ($_SESSION['rights'] === 2)) )
{
    echo "Please get out of here and nobody will get harm.";
    exit();
}

set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');
?>

<?php include_once "View/Layout/head.php" ?>
<link rel="stylesheet" type="text/css" href="/styles/admin.css?v=1.0">
</head>

<body>
<?php include_once "View/Layout/header.php" ?>


<div class="container">
    <div class="row">
        <?php include_once "View/Layout/userManagement.php" ?>
        <?php include_once "View/Layout/lectorManagement.php" ?>
    </div>
</div>

<script src="scripts.js"></script>
</body>
</html>
