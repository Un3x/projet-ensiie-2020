<?php
session_start();
?>

<html lang="en">

    <head>
        <meta charset="utf-8">
        <title>Twitiie</title>
        <link rel="stylesheet" href="../../public/css/style_home.css?v=1.0">
        <link rel="icon" type="img/png" href="../../public/img/icon_ensiie" />
        <script src="../../public/js/scripts.js"></script>
    </head>

    <body>

        <header>
            <div class="topnav-left">
               <a href="home.php"> <h2>Web Uisy</h2> </a>
           </div>
            <div class="topnav-right">
                <a href="../Utils/disconnect.php"><h2>Déconnexion </h2> </a>
            </div>
        </header>

        <div id="lower_div">

            <nav id="leftNav" role="navigation">

            	<div id= "infos_user">
					<img id = "img_user" src="../../public/img/icon_default_user.png">
	                <p id="user_name"> <?php echo $_SESSION['user_name']?> </p>
                </div>

                <ul>
                    <li><a href="home.php?action=viewFeed" title="feed">Mon feed</a></li>
                    <li><a href="home.php?action=viewFollowers" title="abonnés">Mes abonnés</a></li>
                    <li><a href="home.php?action=viewFollows" title="abonnements">Mes abonnements</a></li>
                    <li><a href="home.php?action=viewMyTweets" title="publications">Mes publications</a></li>
                    <li><a href="home.php?action=usersList" title="utilisateurs">Utilisateurs</a></li>
                    <li><a href="home.php?action=hashtags" title="hashtags">Tendances</a></li>
                </ul>

            </nav>

            <div id="appContainer">

            		<?php include_once 'loadView.php'; // chargement de la vue dynamique, correspondante à $GET['action'] ?>
            </div>

        </div>

    </body>

</html>
