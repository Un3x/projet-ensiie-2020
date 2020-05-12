<?php

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/OeuvreRepository.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$docRepository = new \Oeuvre\FilmRepository($dbAdaper);

$genre = 'Documentaire';

$docs = $docRepository->fetchGenre($genre);

?>
<html lang="en">

<table>
    <caption>Liste des films documentaires</caption>
    <tr>
        <th>Titre</th>
        <th>Lien photo</th>
        <th>Date de sortie</th>
        <th>Réalisateur</th>
        <th>Durée (en min)</th>
        <th>Producteur</th>    
    </tr>
<?php foreach($docs as $doc): ?>
    <tr>
        <td><?= $doc->getTitre() ?></td>
        <td><?= $doc->getLienPhoto() ?></td>
        <td><?= $doc->getDateSortie() ?></td>
        <td><?= $doc->getRealisateur() ?></td>            
        <td><?= $doc->getDureeFilm() ?></td>
        <td><?= $doc->getProducteur() ?></td>
    <tr>
<?php endforeach; ?>
    

</table>
</html>