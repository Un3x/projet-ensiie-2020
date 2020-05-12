<html>
    <head>
        <title> Création de recherche</title>
        <meta charset ="utf-8">



    </head>
    <body>

        <div align="center"><h1>Créer une recherche </h1>
        <p> Créer ici votre recherche de mate ! <p>
        <?php if(isset($_SESSION['name']))
        {        
            $dbAdapter = (new DbAdaperFactory())->createService();
            $gameRepository = new \src\Model\repository\GameRepository($dbAdapter);
            $games = $gameRepository->showAcquired($_SESSION['name']);
        }
        else
        {
            header('location: login.php');
        }
        ?>

        <form action="addsearch.php" method="post">
            <div>
                
                    
            <table>
                <tr>
                    <td align="center">
            <!-- <select name="Jeu">
                            <option value="">Sélectionnez votre jeu </option> -->
                        <?php 
                        echo '<select name="jeu">',"\n";
                        echo '<option value="err">Sélectionnez un de vos jeux </option>',"\n";
                        foreach($games as $game)
                        {
                            echo "\t",'<option value="',$game->getName(),'"','>',$game->getName(),'</option>',"\n";
                        
                        }
                        echo '</select>',"\n";

                        ?>
                    </td>
                        </tr>
                        <tr align="right">
                        <td>
                        
                        <input type='string' autocomplete="off" placeholder="Titre de votre recherche" style="width: 600px;" name="title" required value="<?php if(isset($_GET['title'])) { echo htmlspecialchars($_GET['title']); } ?>"/>
                    </td>    
                    </tr>
                        <tr>
                        <td align="left">
                        <label>Nombre de mates recherchés:</label>
                 
                        <input type='int' autocomplete="off" name="playerstofind" style="width: 35px;" required value="<?php if(isset($_GET['nb'])) { echo htmlspecialchars($_GET['nb']); } ?>"/>
                        </td>
                        </tr>
                        <table>
                            
                        <input type = 'submit' name=submit value="Créer">
                   
                    
            </form>
            <div>
            <?php if(isset($_GET['err']))
{
                    $err = $_GET['err'];
                    if($err==1)
                        echo "<p style='color:red'>Veuillez sélectionner un jeu svp</p>";
                }
?>
           
        </div>
    </body>
</html>

