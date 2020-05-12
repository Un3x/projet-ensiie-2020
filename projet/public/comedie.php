<?php

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/OeuvreRepository.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$comedieRepository = new \Oeuvre\FilmRepository($dbAdaper);

$genre = 'Comédie';

$comedies = $comedieRepository->fetchGenre($genre);

?>
<html lang="en">

<table>
    <caption>Liste des films de comédie</caption>
    <tr>
        <th>Titre</th>
        <th>Lien photo</th>
        <th>Date de sortie</th>
        <th>Réalisateur</th>
        <th>Durée (en min)</th>
        <th>Producteur</th>    
    </tr>
<?php foreach($comedies as $comedie): ?>
    <tr>
        <td><?= $comedie->getTitre() ?></td>
        <td><?= $comedie->getLienPhoto() ?></td>
        <td><?= $comedie->getDateSortie() ?></td>
        <td><?= $comedie->getRealisateur() ?></td>            
        <td><?= $comedie->getDureeFilm() ?></td>
        <td><?= $comedie->getProducteur() ?></td>
    <tr>
<?php endforeach; ?>
    

</table>
</html>