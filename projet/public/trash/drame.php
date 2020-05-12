<?php

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/OeuvreRepository.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$drameRepository = new \Oeuvre\FilmRepository($dbAdaper);

$genre = 'Drame';

$drames = $drameRepository->fetchGenre($genre);

?>
<html lang="en">

<table>
    <caption>Liste des films dramatiques</caption>
    <tr>
        <th>Titre</th>
        <th>Lien photo</th>
        <th>Date de sortie</th>
        <th>Réalisateur</th>
        <th>Durée (en min)</th>
        <th>Producteur</th>    
    </tr>
<?php foreach($drames as $drame): ?>
    <tr>
        <td><?= $drame->getTitre() ?></td>
        <td><?= $drame->getLienPhoto() ?></td>
        <td><?= $drame->getDateSortie() ?></td>
        <td><?= $drame->getRealisateur() ?></td>            
        <td><?= $drame->getDureeFilm() ?></td>
        <td><?= $drame->getProducteur() ?></td>
    <tr>
<?php endforeach; ?>
    

</table>
</html>