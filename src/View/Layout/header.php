<?php
session_start();
?>

<header>
    <ul class="topnav">
        <li class="left-side"><a class="site-name" href="/">Bakaraoke</a></li>
        <li class="left-side"><a class="nav-link" href="/Forms/search.php">Advanced Search</a></li>
    <?php if ( isset($_SESSION['rights']) && ( $_SESSION['rights']===1 || $_SESSION['rights']===2 ) ) { ?>
        <li class="left-side"><a class="nav-link" href="/admin.php">Manage Users</a></li>
    <?php } ?>
        <li class="left-side"><a class="nav-link" href="/modifyUser.php">Edit your profile</a></li>
        <li class="login-feedback">
        <?php
        if (isset($_SESSION['username']))
        {
            $idSession=$_SESSION['id'];
            $userSession=$_SESSION['username'];
            echo "You are logged in as $userSession. ";
            echo '<a href="Forms/logout.php">Logout</a> / <a href="/modifyUser.php">Settings</a>';
        }
        else
        {
            echo "You are logged out : <a class='nav-link' href='login.php'>Login</a>\n";
        }
        ?>
    </ul>
        </li>
</header>
