<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../form/style.css" />
        <title>Coroshop : rechercher un objet</title>
        <link rel="icon" href="photo/image.ico" />

    </head>
    <?php include("../src/header.php"); ?><?php
    if (isset($_POST['page'])){
        $_SESSION['page']=$_POST['page'];
       
    }?>
	<?php include("../src/recherche_objet_formulaire.php"); ?>
    <?php include("../src/affiche_liste_objet.php"); ?>
   
    <?php include("../src/footer.php"); ?>
</html>
