<?php
session_start();
?>

<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>

                <li class="nav-item active">
                    <?php
                    if (isset($_SESSION['username'])){
                        $idSession=$_SESSION['id'];
                        $userSession=$_SESSION['username'];
                        echo "<p> You are logged in as $userSession, $idSession </p>";
                    }
                    else {
                        echo '<p> You are logged out : <a class="nav-link" href="login.php"></p>';
                    }
                    ?>
                </li>
            </ul>
        </div>
    </nav>
</header>
