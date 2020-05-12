<?php

$page_list = array(
    array(
        "name" => "accueil",
        "title" => "Bienvenue sur Spotifiie !",
        "menutitle" => "Spotifiie"),
    array(
        "name" => "register",
        "title" => "S'inscrire",
        "menutitle" => "Inscription"),
);

function generateMenu($connected, $page,$assos) {
    if ($connected) {
        echo <<<CHAINE_DE_FIN
        <a class="navbar-brand" id='spotifiie' href="#">Spotifiie</a>
            <div class="collapse navbar-collapse" id="navbarsX">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a id="ma_musique" class="nav-link" href='#'>Ma musique</a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://localhost" id="dropdownX" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Assos</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownX">
CHAINE_DE_FIN;
            for($i = 0; $i < count($assos); ++$i){
                        echo '<a class="dropdown-item asso" id="'.$assos[$i].'" href="#">'.$assos[$i].'</a>';
            }
                    echo '</div>';
                    echo '</li>';
                    echo '</li>';
                    echo '<li class="nav-item">';
                    echo '<p class="navbar-brand bienvenue">Bienvenue '.$_SESSION['Utilisateur'].'!</p>';
                    echo '</li>';
                    
                echo '</ul>';
            
        printLogoutForm($page);
		echo "</div>";
    } else {
        echo <<<CHAINE_DE_FIN
        <a class="navbar-brand" href="?page=accueil">Spotifiie</a>
            <div class="collapse navbar-collapse" id="navbarsX">
                <ul class="navbar-nav mr-auto">
                    <li class="nav-item">
                        <a class="nav-link" href="?page=register">Inscription<span class="sr-only">(current)</span></a>
                    </li>
                    <li class="nav-item dropdown">
                        <a class="nav-link dropdown-toggle" href="https://localhost" id="dropdownX" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Aide</a>
                        <div class="dropdown-menu" aria-labelledby="dropdownX">
                            <a class="dropdown-item" href="?page=questions">Une question ?</a>
                            <a class="dropdown-item" href="?page=about">About</a>
                        </div>
                </ul>
CHAINE_DE_FIN;
        printLoginForm($page);
        echo '</div>';
		
    }
}



function generateVerticalMenu($liste_playlists) {
    echo '<div id = verticalMenuFrame>';
    echo '<div id=verticalMenu>';
    echo '<ul class="navbar-nav flex-column">';
	echo '<li class = "nav-item"><span style="color: white">Mes playlists</span></li>';
        echo '<li class="nav-item" style="margin-left:10px">';
    echo '<a class="nav-link" href="#" id="nouvelle_playlist" style="color:white">Nouvelle playlist<span class="sr-only">(current)</span></a>';
    echo '</li>';
    for($i = 0; $i < count($liste_playlists); ++$i) {
            echo '<li class="nav-item" style="margin-left:10px">';
            echo "  <a class='nav-link playlist' href='#' id=".$liste_playlists[$i]->id.">".$liste_playlists[$i]->titre."<span class='sr-only'>(current)</span></a>";
            echo '</li>';
    }
    echo <<<_FIN
    
   </ul>
   </div>
    </div>
        <div  id="container_player">
            <img id="imagePlayer" src="images/ado.jpg">
        <audio id="player" controls="controls" style="width:100%">
            <source src="musiques/7.mp3" type="audio/mp3" />
        </audio>
        <script>
        var player = document.getElementById('player');
        player.onended = function(){
        $('#container_player').load('index.php?todo=musique_suivante');
        };
        </script>
        </div>
    
   
       
_FIN;

}

function checkPage($askedPage) {
    global $page_list;

    foreach ($page_list as $page) {
        if ($askedPage === $page["name"]) {
            return true;
        }
    }
    return false;
}

function getPageTitle($askedPage) {
    global $page_list;

    foreach ($page_list as $page) {
        if ($askedPage === $page["name"]) {
            return $page["title"];
        }
    }
}

function generateHTMLHeader($title, $path) {
    echo <<<CHAINE_DE_FIN
    <!DOCTYPE html>
    <html>
    <head>
        <title>$title</title>
        <meta charset = 'utf-8'>
        <meta name = 'author' content = 'Equipe'/>
        <meta http-equiv = 'X-UA-Compatible' content = 'IE=edge'>
        <meta name = 'viewport' content = 'width=device-width, initial-scale=1'>
        <!--js-->
        <script src = 'js/jquery.min.js'></script>
        <script src='js/popper.min.js'></script>
        <script src='js/bootstrap.min.js'></script>
        <script src='js/jquery.dataTables.min.js'></script>
		<script src="js/jquery-ui.js"></script>
        <script src='js/code.js'></script>
        <!--CSS--> 
        <link href = 'css/jquery.dataTables.min.css' rel = 'stylesheet'>
        <link rel="stylesheet" href="css/jquery-ui.min.css">
        <link href = 'css/bootstrap.min.css' rel = 'stylesheet'>
        <link href=$path rel='stylesheet'>
		<link rel="stylesheet" href="css/jquery-ui.min.css">
        <link rel="stylesheet" type="text/css" href="css/perso.css" />
    </head>
CHAINE_DE_FIN;
}

function generateHTMLFooter() {
    echo '</body>';
    echo '</html>';
}
