<?php

include '../src/Oeuvre.php';
include '../src/OeuvreRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Livre.php';
include '../src/Film.php';
include '../src/Serie.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$livreRepository = new \Oeuvre\OeuvreRepository($dbAdaper);
$livres = $livreRepository->fetchAllLivre();

$filmRepository = new \Oeuvre\OeuvreRepository($dbAdaper);
$films = $filmRepository->fetchAllFilm();

$serieRepository = new \Oeuvre\OeuvreRepository($dbAdaper);
$series = $serieRepository->fetchAllSerie();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Medialiste</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Le grand trac">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css" type="text/css">
    <script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1/jquery.min.js"></script>
    <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/jquery-ui.min.js"></script>
    <link rel="stylesheet" href="https://ajax.googleapis.com/ajax/libs/jqueryui/1.11.4/themes/smoothness/jquery-ui.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.9/umd/popper.min.js"></script>
    <script type="text/javascript" src="http://code.jquery.com/jquery-latest.js"></script>
    <script type="text/javascript" src="js/scripts.js"></script>
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Medialiste</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/index.php">Home</a>                      
                </li>
                <li class="nav-item active">
                    <a class="nav-link" href="/signIn.php">Sign in</a>
                </li>                                          
                <li class="nav-item active">                                          
                    <a class="nav-link" href="/signUp.php">Sign up</a>
                </li>
                <li class="nav-item active">                                          
                    <a class="nav-link" href="/affichage.php">Affichage liste</a>
                </li>
                <li class="nav-item active">                                          
                    <a class="nav-link" href="/affichage2.php">Affichage oeuvre</a>
                </li>    
            </ul>      
        </div>
      </nav>        
</header>
<div class="container">
    <div class="row">  
        <div class="col-sm-12">
            <h1>Oeuvres</h1>
        </div>
        <form name="form" action="" method="post">
        <input type="radio" name="choix" value="livre" id="1"/><label for="livre">Livre</label>
        <input type="radio" name="choix" value="film" id="2"/> <label for="film">Film</label>
        <input type="radio" name="choix" value="serie" id="3"/> <label for="serie">Serie</label>
        <input type="submit" value="Envoyer">
        </form>
        <div class="col-sm-12">
            <table class="table">
                <?php if($_POST['choix']=='livre'):?>
                    <tr>
                        <th>Numero</th>
                        <th>Titre</th>
                        <th>Photo</th>
                        <th>Date_sortie</th>
                        <th>Pages</th>
                        <th>Langue</th>
                        <th>Genre</th>
                    </tr> 
                    <?php foreach($livres as $livre): ?>
                        <tr>
                            <td><?= $livre->getNumero() ?></td>
                            <td><?= $livre->getTitre() ?></td>
                            <td><?= $livre->getLienPhoto() ?></td>
                            <td><?= $livre->getDateSortie()->format('Y-m-d') ?></td>
                            <td><?= $livre->getNbPages() ?></td>            
                            <td><?= $livre->getLangue() ?></td>
                            <td><?= $livre->getGenreLivre() ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php elseif($_POST['choix']=='film'):?>
                    <tr>
                        <th>Numero</th>
                        <th>Titre</th>
                        <th>Photo</th>
                        <th>Date_sortie</th>
                        <th>Realisateur</th>
                        <th>Genre</th>
                        <th>Duree</th>
                        <th>Producteur</th>
                    </tr> 
                    <?php foreach($films as $film): ?>
                        <tr>
                            <td><?= $film->getNumero() ?></td>
                            <td><?= $film->getTitre() ?></td>
                            <td><?= $film->getLienPhoto() ?></td>
                            <td><?= $film->getDateSortie()->format('Y-m-d') ?></td>
                            <td><?= $film->getRealisateur() ?></td>
                            <td><?= $film->getGenreFilm() ?></td>            
                            <td><?= $film->getDureeFilm() ?></td>
                            <td><?= $film->getProducteur() ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php else: ?>
                    <tr>
                        <th>Numero</th>
                        <th>Titre</th>
                        <th>Photo</th>
                        <th>Date_sortie</th>
                        <th>Nombre dépisodes</th>
                        <th>Nombre de saisons</th>
                        <th>Duree</th>
                        <th>Genre</th>
                        <th>Est-ce un animé?</th>
                    </tr> 
                    <?php foreach($series as $serie): ?>
                        <tr>
                            <td><?= $serie->getNumero() ?></td>
                            <td><?= $serie->getTitre() ?></td>
                            <td><?= $serie->getLienPhoto() ?></td>
                            <td><?= $serie->getDateSortie()->format('Y-m-d') ?></td>
                            <td><?= $serie->getNbEp() ?></td>            
                            <td><?= $serie->getNbSaisons() ?></td>
                            <td><?= $serie->getDureeSerie() ?></td>
                            <td><?= $serie->getGenreSerie() ?></td>
                            <td><?= $serie->getAnime() ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</div>
<div>
    <input type="button" name="type" id="film" value="film" onClick="document.location.href='/affichage_addFilm.php'"><label for="film">Film</label>
    <input type="button" name="type" id="serie" value="serie" onClick="document.location.href='/affichage_addSerie.php'"><label for="serie">Série</label>
    <input type="button" name="type" id="livre" value="livre" onClick="document.location.href='/affichage_addLivre.php'"><label for="livre">Livre</label>
</div>
<script src="js/scripts.js"></script>
</body>
</html>