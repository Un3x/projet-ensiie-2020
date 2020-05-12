<?php
function loadView($view,$data){
    $dbfactory=new DbAdaperFactory();
    $dbAdapter=$dbfactory->createService();
    ?>
    <!doctype html>
    <html lang="fr">
    <head>
    <meta charset="utf-8">
    <title>FindAMate</title>
    <link rel="stylesheet" href="style.css">
    </head>
    <body>
    <?php include_once '../src/View/Layout/header.php' ?>
    <div class="main-container">
        <?php include_once '../src/View/'.$view.'.php'?>
        </div>
    <?php include_once '../src/View/Layout/footer.php'?>
        </body>
        </html>
    <?php
    
}
?>