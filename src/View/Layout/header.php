<?php
session_start();
?>

<header>
    <ul class="topnav">
        <li><a class="site-name" href="#">Bakaraoke</a></li>
        <li><a class="nav-link" href="search.php">Advanced Search</a></li>
    <?php if ( isset($_SESSION['rights']) && ( $_SESSION['rights']===1 || $_SESSION['rights']===2 ) ) { ?>
        <li><a class="nav-link" href="admin.php">Manage Users</a></li>
    <?php } ?>
        <li><a class="nav-link" href="modifyUser.php">Edit your profile</a></li>
        <li class="login-feedback">
        <?php
        if (isset($_SESSION['username']))
        {
            $idSession=$_SESSION['id'];
            $userSession=$_SESSION['username'];
            echo "You are logged in as $userSession, $idSession\n";
        }
        else
        {
            echo "You are logged out : <a class='nav-link' href='login.php'>Login</a>\n";
        }
        ?>
        </li>
    </ul>
</header>
