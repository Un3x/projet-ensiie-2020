<?php 
session_start();
include("db_connect.php");
?>


<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="style_MyM.css" />
        <title>MyManager</title>
    </head>
    
    <body>
        <div id="bloc_page">

            <!--Le header de la page-->
            <?php include('header.php'); ?>
            
            <!--La bannière-->
            <div id="banniere_accueil">
                <div id="banniere_description">
                    <a href="https://www.footballmanager.com/fr" title="FM">
                        Football Manager
                    </a>
                </div>
            </div>
            <br /><br />


            <!--Le corps de la page-->
            <h1 class="titre_accueil">Bienvenue sur MyManager</h1>
            <h2><img src="images/ico_ballon.png" alt="Ballon de football" class="ico_categorie" />
                Deviens le meilleur Manager
            </h2>
            <br /><br />
            <section>
                
                <article>
                    <h2 style="color:blue"><strong><em>Qu'est ce que FM ?</em></strong></h2>
                    <p style="font-size:0.9em"> Football Manager est un jeu de simulation et de gestion footballistique développée par Sports Interactive.<br />
                    Gérez votre club de football comme vous l'entendez. Chaque décision compte dans Football Manager.<br /><br />
                    Entrez dans le tunnel pour rejoindre un monde de football vivant et authentique. Ici, votre opinion sur le football compte !
                    Voici un monde qui récompense les plus avisés et les plus avertis, mais qui contrairement aux autres jeux, n'a pas de fin prédéfinie ni de script imposé... les possibilités et les occasions sont illimitées. Chaque club a une histoire à raconter, et la vôtre ne fait que commencer !<br /><br />  
                    On dit que le football est jeu de rêveurs. Eh bien, les entraîneurs sont une race particulière de rêveurs.
                    Les problèmes sont pour eux des occasions... l'occasion de prouver leur valeur face aux meilleurs mondiaux, de développer et d'appliquer une nouvelle philosophie, d'infléchir le cours d'une carrière, de hisser le club vers de nouveaux sommets et d'enfin décrocher le trophée.
                    À vous de vous frayer un chemin vers le sommet... assumez vos choix et leurs conséquences.
                    </p>
                    <br /><br />
                    
                    <iframe width="560" height="315" src="https://www.youtube.com/embed/FhZnNPHTzX8" 
                    frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" 
                    allowfullscreen></iframe>
                    
                    <br /><br />
                    <h2 style="color:blue"><strong><em>Qui sommes nous?</em></strong></h2>
                    <p style="font-size:0.9em">Nous sommes 4 étudiants d'une école d'informatique et de mathématiques, l'ENSIIE - Ecole Nationale Supérieure d'informatique pour l'Industrie et l'Entreprise - Akarioh Samir, Bougrine Rayan, Karunanayakage Shamal et Lachat Gabin. <br />
                    Nous avons décidé de développer ce site internet dans le cadre d'un projet scolaire. <br /><br />
                    Fan du jeu, nous avons décidé de développer notre site autour de Football Manager, et l'idée nous est venue assez rapidement dûe au plaisir de faire notre propre équipe, associé à la difficulté de trouvé les joueurs de football nécessaire.
                    <br /><br />
                    Nous avons voulu créer un site de partage où les fans du jeu pourraient partager leur équipe et leur tactique, échanger avec les autres à travers un forum ou encore rechercher des joueurs pour former leurs équipes. 
                    </p>
                    <br /><br />

                    
                    <h2 style="color:blue"><strong><em>Maintenant c'est à toi de jouer</em></strong></h2>
                    <p>
                    <ul>
                        <li>Viens découvrir les tactiques de la communauté, notes les ou commentes les</li>
                        <li>Partages ton équipe</li>
                        <li>Recherches les joueurs dont tu aurais besoin</li>
                        <li>Recherches les futurs cracks pour améliorer ton équipe</li>
                        <li>Viens discuter avec la communauté avec notre forum</li>
                        <li>Améliores ta popularité au sein de la communauté</li>
                    </ul>
                    Et deviens the manager !</p>
                </article>
                <aside class="aside_accueil">
                    <img src="images/coach.png" alt="" class="coach" />
                 </aside>
            </section>

            <br /><br /><br />


            <!--Le footer du site-->
            <?php include('footer.php'); ?>
            
        </div>
    </body>
</html>
