<?php
session_start();

include_once '../src/User.php';
include_once '../src/UserRepository.php';
include_once '../src/Kara.php';
include_once '../src/KaraRepository.php';
include_once '../src/Lector.php';
include_once '../src/LectorRepository.php';
include_once '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
$lectorRepository = new \Lector\LectorRepository($dbAdaper);
$lectors = $lectorRepository->fetchAll();
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
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>User List</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>username</th>
                    <th>email</th>
                    <th>creation date</th>
                    <th>Action</th>
                </tr>
                <?php foreach($users as $user): ?>
                    <tr>
                        <td><?= $user->getId() ?></td>
                        <td><?= $user->getUsername() ?></td>
                        <td><?= $user->getEmail() ?></td>
                        <td><?= $user->getCreatedAt()->format(\DateTime::ATOM) ?></td>
                        <td>
                            <form method="POST" action="/deleteUser.php">
                                <input name="user_id" type="hidden" value="<?= $user->getId() ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>

        <div class="col-sm-12">
            <h1>Lector List</h1>
        </div>
        <div class="col-sm-12">
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>ip</th>
                    <th>port</th>
                </tr>
                <?php foreach($lectors as $lector): ?>
                    <tr>
                        <td><?= $lector->getId() ?></td>
                        <td><?= $lector->getIP() ?></td>
                        <td><?= $lector->getPort() ?></td>
                        <td>
                            <form method="POST" action="/deleteLector.php">
                                <input name="lector_id" type="hidden" value="<?= $lector->getId() ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
    </div>
</div>
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

    <form method="POST" action="/play.php">
        <input name="test" type="hidden" value="testvalue">
        <button type="submit">Play</button>
    </form>

    <form method="POST" action="./idtest.php">
        <input type="number" name="id">
        <button type="submit">Add kara (by id)</button>
    </form>


<!-- End of the test area -->

<!-- This is the test area for displaying the current queue -->

<button type="button" onclick="loadQueue()">Refresh Queue</button>
<button type="button" onclick="autoRefreshQueue(10000)">Set Auto Refresh Queue</button>
<div id="karaQueue">
<span>
coucou
</span>
</div>

<!-- End of the test area -->

<!-- This is the test area for searching a kara -->

<input type="text" id="karaSearch" onkeydown="dynamicSearch()" placeholder="Search for karas">

<div id="karaList">
    <ul>
        <?php foreach ($karas as $kara): ?>
            <form method="POST" action="./idtest.php">
                <li id="aKaraInKaraList">
                    <input type="hidden" name="id" value=<?= $kara->getId()?>>
                    <div><?= $kara->getString()?></div>
                    <button type="submit">Add</button>
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
