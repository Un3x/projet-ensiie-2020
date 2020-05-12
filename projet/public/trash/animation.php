<?php

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/OeuvreRepository.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$animationRepository = new \Oeuvre\FilmRepository($dbAdaper);

$genre = 'Animation';

$animations = $animationRepository->fetchGenre($genre);

?>
<html lang="en">

<table>
    <caption>Liste des films d'animation</caption>
    <tr>
        <th>Titre</th>
        <th>Lien photo</th>
        <th>Date de sortie</th>
        <th>Réalisateur</th>
        <th>Durée (en min)</th>
        <th>Producteur</th>    
    </tr>
<?php foreach($animations as $animation): ?>
    <tr>
        <td><?= $animation->getTitre() ?></td>
        <td><?= $animation->getLienPhoto() ?></td>
        <td><?= $animation->getDateSortie() ?></td>
        <td><?= $animation->getRealisateur() ?></td>            
        <td><?= $animation->getDureeFilm() ?></td>
        <td><?= $animation->getProducteur() ?></td>
    <tr>
<?php endforeach; ?>
    

</table>
</html>