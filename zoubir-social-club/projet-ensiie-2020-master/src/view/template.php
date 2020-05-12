<?php

function loadView($view, $data) {
    //$dbfactory = new \Rediite\Model\Factory\dbFactory();
    //$dbAdapter = $dbfactory->createService();
    ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>Zoubir-Social-Club</title>
        <link rel="stylesheet" href="style.css">

    </head>
    <body>
    <?php include_once '../src/view/Layout/header.php' ?>
    <div class="main-container">
        <?php include_once '../src/view/'.$view.'.php' ?>
    </div>
    <?php include_once '../src/view/Layout/footer.php' ?>
    </body>
    </html>
<?php
}
?>
