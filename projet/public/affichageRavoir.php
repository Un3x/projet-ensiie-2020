<?php

include '../src/Ravoir.php';
include '../src/RavoirRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$ravoirRepository = new \User\RavoirRepository($dbAdaper);
$ravoirs = $ravoirRepository->fetchAll();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Medialiste</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Ravoir List</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>Pseudo utilisateur</th>
                    <th>Numéro de la liste</th>
                </tr>
                <?php foreach($ravoirs as $ravoir): ?>
                    <tr>
                        <td><?= $ravoir->getPseudo() ?></td>
                        <td><?= $ravoir->getIdListe() ?></td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
<script src="js/scripts.js"></script>
</body>
</html>