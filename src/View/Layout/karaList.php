<?php
include_once 'Karas/Kara.php';
include_once 'Karas/KaraRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$karaRepository = new \Kara\KaraRepository($dbAdaper);
$karas = $karaRepository->fetchAll();
?>

<input type="text" id="karaSearch" onkeyup="dynamicSearch()" placeholder="Search for karas">

<div id="karaList">
    <ul>
        <?php foreach ($karas as $kara): ?>
            <form method="POST">
                <li id="aKaraInKaraList">
                    <button type="button" onclick="addKara(<?= $kara->getId()?>)">Add</button>
                    <button type="button" onclick="toggleKaraInfo(<?= $kara->getId()?>)">Infos</button>
                    <?= $kara->getString()?>
                    <div id=KaraInfo_<?= $kara->getId()?> style="display: none">
                        <h3>Infos</h3>
                        <ul>
                            <li>Source Name : <?= $kara->getSourceName()?></li>
                            <li>Song Name : <?= $kara->getSongName()?></li>
                            <li>Category : <?php    echo $kara->getCategory();
                                                    echo $kara->getSongNumber();?></li>
                            <li>Author Name : <?= $kara->getAuthorName()?></li>
                            <li>Language : <?= $kara->getLanguage()?></li>
                            <li>ID : <?= $kara->getID()?></li>
                        </ul>
                    </div>
                </li>
            </form>
        <?php endforeach; ?>
    </ul>
</div> 
<script src="/scripts/karaList.js"></script>
