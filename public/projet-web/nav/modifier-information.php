<?php

require "../header.php";

?>

<main>
<link rel="stylesheet" href="/projet-web/style/information.css">

<div class="container myContainer">
        <div class="container ulContainer">

<?php if(isset($_SESSION["userId"])){?>
                <form action='/projet-web/includes/modifier-information.inc.php' method='POST' enctype="multipart/form-data">
                <h3 class="titre">Mes informations</h3>
                <table>
                        <tr>
                        <td><span class="catégorie"> Nom : </span></td><td><input type='text' name='nomModif' value="<?php echo $_SESSION["userNom"]; ?>"/></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie"> Prénom : </span></td><td><input type='text' name='prenomModif' value='<?php echo $_SESSION["userPrenom"];?>'/></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie"> Mail : </span></td><td><input type='text' name='mailModif' value='<?php echo $_SESSION["userMail"];?>'/></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie"> Tel : </span></td><td><input type='text' name='telModif' value='<?php echo $_SESSION["userTel"];?>'/></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie"> Voiture : </span></td><td><input type='text' name='voitureModif' value='<?php echo $_SESSION["userVoiture"];?>' /></td>
                        </tr>
                        <tr>
                        <td><span class="catégorie"> Chnager photo de profil : </span></td>
                        <td><input type="file" name="profil"/><button name="deletephoto" type="submit">Supprimer la photo</button></td>

                        </tr>

</table>
                <div class="container buttonContainer">
                <button name="modifierInfos" type="submit">Sauvegarder</button>
</div>
                </form>
       <?php }else{ ?>
                <p>Connectez vous pour avoir accès à vos informations</p>
        <?php } ?>


        </div>
</div>

</main>

<?php
require "../footer.php"
?>
