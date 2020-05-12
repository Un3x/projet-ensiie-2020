<?php

use Suivre\SuivreRepository;
use Liste\ListeRepository;

include '../src/Oeuvre.php';
include '../src/Film.php';
include '../src/EtreDansRepository.php';
include '../src/RavoirRepository.php';
include '../src/SuivreRepository.php';
include '../src/Factory/DbAdaperFactory.php';

header('Location: /profil.php');

$dbAdaper = (new DbAdaperFactory())->createService();
$ravoirRepository = new \Ravoir\RavoirRepository($dbAdaper);
$suiveurRepository = new \Suivre\SuivreRepository($dbAdaper);
$oeuvreRepository = new \Oeuvre\OeuvreRepository($dbAdaper);

// On récupère le pseudo du suiveur sélectionné
$pseudo = $suiveur->getUsername();

// Récuprération de toutes ses listes
$listes = $ravoirRepository->fetch($pseudo);

?>
<html lang="en">

<h1>Voici les listes du suiveur sélectionné</h1>

<?php foreach($listes as $liste): ?>

        <h2><?= $liste->getNomListe() ?></h2>

        <?php $oeuvres = $oeuvreRepository->fetch($liste->getId()); ?>

        <!-- Pour chaque liste, on affiche les oeuvres qui s'y trouvent-->
        <?php foreach($oeuvres as $oeuvre): ?>
            <h3><?= $oeuvre->getTitre() ?></h3>
        <?php endforeach; ?>

<?php endforeach; ?>

</table>
</html>