<?php
session_start();
set_include_path('.:' . $_SERVER['DOCUMENT_ROOT'] . '/../src');

include_once 'Karas/Kara.php';
include_once 'Karas/KaraRepository.php';
include_once 'Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$karaRepository = new \Kara\KaraRepository($dbAdaper);
$karas = $karaRepository->fetchAll();

?>

<html lang="en">
<head>
    <meta charset="utf-8">
    <title>Projet web Ensiie</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Thomas COMES">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="style.css?v=1.0">
</head>

<body>
<header>
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Home</a>
                </li>
            </ul>
        </div>
    </nav>
</header>
<?php
if (isset($_SESSION['username'])){
    $idSession=$_SESSION['id'];
    $userSession=$_SESSION['username'];
    echo "<p> you are logged in as $userSession, $idSession </p>";
}
else {
    echo "<p> you are logged out </p>";
}
?>

<!-- This is the test area for communication with lektor -->

<?php echo $_SERVER['REMOTE_ADDR'] ?>

    <form method="POST" action="Forms/play.php">
        <input name="test" type="hidden" value="testvalue">
        <button type="submit">Play</button>
    </form>

    <form method="POST" action="Forms/idtest.php">
        <input type="number" name="id">
        <button type="submit">Add kara (by id)</button>
    </form>


<!-- End of the test area -->

<!-- This is the test area for displaying the current queue -->

<button type="button" onclick="loadQueue()">Refresh Queue</button>
<button id="toggleButton" type="button" onclick="toggleAutoRefreshQueue(2000)">Toggle Auto Refresh Queue (current : off)</button>
<div id="karaQueue">
</div>

<!-- End of the test area -->

<!-- This is the test area for searching a kara -->

<input type="text" id="karaSearch" onkeydown="dynamicSearch()" placeholder="Search for karas">

<div id="karaList">
    <ul>
        <?php foreach ($karas as $kara): ?>
            <form method="POST">
                <li id="aKaraInKaraList">
                    <div><?= $kara->getString()?></div>
                    <button type="button" onclick="addKara(<?= $kara->getId()?>)">Add</button>
                    <button type="button" onclick="toggleKaraInfo(<?= $kara->getId()?>)">Infos</button>
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

<!-- End of the test area -->

<script src="scripts.js"></script>
</body>
</html>
