<?php

function loadView($view, $data) {
    $dbAdapter = (new DbAdapterFactory())->createService();
    $bookRepository = new \Book\BookRepository($dbAdapter);
    ?>
    <!doctype html>
    <html lang="fr">
    <head>
        <meta charset="utf-8">
        <title>BIblIothEque</title>
        <meta name="description" content="Projet web Ensiie">
        <meta name="author" content="Validations">
        <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
        <link rel="stylesheet" href="style.css?v=1.0">
        <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
        <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    </head>
    <?php if($view != 'accueil'){ 
        include_once '../src/View/header.php';
        } ?>
    <body>
        <?php include_once '../src/View/'.$view.'.php'; ?>
    </body>
    </html>
<?php
}
?>