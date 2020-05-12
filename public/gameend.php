<?php

include '../src/Utilisateur.php';
include '../src/Map.php';
include '../src/MapRepository.php';
include '../src/UtilisateurRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$utilisateurRepository = new \Utilisateur\UtilisateurRepository($dbAdaper);
$mapRepository = new \Map\MapRepository($dbAdaper);
$utilisateurs = $utilisateurRepository->fetchAll();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>La Ligue des Deglingos</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Theau FERNANDEZ / Quentin JURY / Gabriel Meziere">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>

<div class="endgame">
    <p>L'équipe <?php echo(random_int(1, 2)) ?> a gagné !</p>
    <form action="/reset_game.php">
        <button class="gamebutton">Retour au menu</button>
    </form>
</div>

</body>
</html>
