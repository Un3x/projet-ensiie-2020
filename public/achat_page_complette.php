<?php 
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <link rel="stylesheet" href="../form/style.css" />
        <title>Coroshop : acheter un objet</title>
        <link rel="icon" href="photo/image.ico" />

    </head>
    <?php include("../src/header.php"); ?>
    <?php
    
    $_SESSION['ID_objet']=$_GET['ID_objet'];
     ?>
    <?php include("../src/page_vente.php"); ?>
   
    <?php include("../src/footer.php"); ?>
</html>
