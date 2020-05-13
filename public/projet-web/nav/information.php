<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/information.css">

<div class="container myContainer">
        <div class="container ulContainer">
<?php

        if(isset($_SESSION["userId"])){//Si l'utilisateur est connecté
                ?>
                <h3 class="titre">Mes informations</h3>
                <table>
                        <tr>
                        <td><span class="catégorie">Nom : </span></td><td><span class="info"><?php echo $_SESSION["userNom"] ?></span></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie">Prénom : </span></td><td><span class="info"><?php echo $_SESSION["userPrenom"] ?></span></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie">Mail : </span></td><td><span class="info"><?php echo $_SESSION["userMail"] ?></span></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie">Tel : </span></td><td><span class="info"><?php echo $_SESSION["userTel"] ?></span></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie">Voiture : </span></td><td><span class="info"><?php echo $_SESSION["userVoiture"] ?></span></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie">Nombre de Points : </span></td><td><span class="info"><?php 
                        $sql = "SELECT nombre_place_validee FROM trajet WHERE id_conducteur=? ";
                        $stmt = $conn->prepare($sql);
                        if($stmt==false){

                        }else{
                                $stmt->execute(array($_SESSION['userId']));
                                $res=0;
                                while($nombrePlace = $stmt->fetch()){
                                        $res += $nombrePlace['nombre_place_validee'];
                                }
                        }

                        echo $res ?></span></td>
                        </tr>
        </table>
                <div class="container buttonContainer">
                <form action="/projet-web/includes/deconnexion.inc.php" method="POST">
                <a href="modifier-information.php"><button class="modifierInfos" type="button">Modifier</button></a>
                <button class="deconnexion" type="submit" value="logout-submit">Deconnexion</button>
                </form>
                </div>
                <?php
        }else{
                echo '<p>Connectez vous pour avoir accès à vos informations</p>';
        }

?>
        </div>
</div>


</main>

<?php
require "../footer.php"
?>
