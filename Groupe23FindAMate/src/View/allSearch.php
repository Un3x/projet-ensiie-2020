<html>
    <head>
        <title> Find a party</title>
        <meta charset ="utf-8">
    </head>
    <body>
        <form action = "allSearch.php" method = "post">
            <p>
            <div align="center">
                <label for="Jeu">Rechercher</label>
                <input type ="text" id="gamename" name = "gamename" placeholder="ex : League of Legends">
            </div>
            </p>
        </form> </br> </br>
        <p>
        <div>
            <?php
                $dbAdaper = (new DbAdaperFactory())->createService();
                $searchRepository = new \src\Model\repository\SearchRepository($dbAdaper);
                if(isset($_POST['gamename']))
                {
                    $searchs = $searchRepository->fetchLikeAll(strtolower((htmlspecialchars($_POST['gamename']))));
                }
                else
                {
                    $searchs = $searchRepository->fetchAll();
                }
                foreach($searchs as $search)
                {
                    echo '<div class="rectangle" <h2><strong> <div align="center">'.htmlspecialchars($search->getTitle()).'</strong></h2></br></div>';
                    echo '<strong>Jeu : </strong>'.$search->getGameName().'<br/>';
                    echo '<strong>Utilisateur en recherche : </strong><a href="profil.php?pseudo='.htmlspecialchars($search->getUsername()).'">'.htmlspecialchars($search->getUsername()).'</a></br>';
                    echo '<p><strong>Nombre de joueurs recherchés: </strong>'.htmlspecialchars($search->getPlayersToFind()).'<form method = "POST" action="salon.php"><button class="button" name="Rejoindre" type="submit" value='.$search->getId().'>Rejoindre</button></form></p>';
                    echo '</div>';
                }   
                ?> 
        </div>
        </p>
    </body>
</html>