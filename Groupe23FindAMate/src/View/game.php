<html>
    <head>
        <title> Ajout de jeu - Find A Mate</title>
        <meta charset ="utf-8">

    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="css/styles.css?v=1.0">
    <link rel="stylesheet" href="style.css">

    </head>
    <body>
        <div align="center"> <h1>Requête d'ajout d'un jeu</h1> 
        </br></br></br></br>
        <form action="addgame.php" method = "post" >
        Nom du jeu : <input type="text" placeholder="Champ Obligatoire" name="gamename" required></br></br>
        Est-ce que le jeu est gratuit ? <input type="radio" name="isFree" value="1"> Oui 
                                        <input type="radio" name="isFree" value="0"> Non </br></br>
        Description: <textarea name="description" rows="5" cols="40"></textarea></br></br>
        <button class="button" type="submit" name=valider> Valider </button> </br>
        </form>
         
        <?php

    if(isset($_GET['erreur']))
    {

        echo "<font color='red'>".$_GET['erreur']."</font color>";
    }
        ?>

        </div>

    </body>
</html>