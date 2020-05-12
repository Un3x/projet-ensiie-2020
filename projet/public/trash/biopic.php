<?php

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/OeuvreRepository.php';
include '../src/FilmRepository.php';
include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$biopicRepository = new \Oeuvre\FilmRepository($dbAdaper);

$genre = 'Biopic';

$biopics = $biopicRepository->fetchGenre($genre);

?>
<html lang="en">

<table>
    <caption>Liste des films biopic</caption>
    <tr>
        <th>Titre</th>
        <th>Lien photo</th>
        <th>Date de sortie</th>
        <th>Réalisateur</th>
        <th>Durée (en min)</th>
        <th>Producteur</th>    
    </tr>
<?php foreach($biopics as $biopic): ?>
    <tr>
        <td><?= $biopic->getTitre() ?></td>
        <td><?= $biopic->getLienPhoto() ?></td>
        <td><?= $biopic->getDateSortie() ?></td>
        <td><?= $biopic->getRealisateur() ?></td>            
        <td><?= $biopic->getDureeFilm() ?></td>
        <td><?= $biopic->getProducteur() ?></td>
    <tr>
<?php endforeach; ?>
    

</table>
</html>