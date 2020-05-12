<?php

use User\UserRepository;
use Interest\InterestRepository;


include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/InterestRepository.php';

session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);

$username = $_SESSION['username'];
$email = $_SESSION['email'];
$interestRepository = new InterestRepository($dbAdaper);
$interestsAll = $interestRepository->fetchAll();
foreach ($interestsAll as $interest) {
    $userRepository->countsub($interest->getTheme());
}
$interestsUser = $userRepository->fetchInterests($username);
$posts = $userRepository->fetchPosts($username);

?>
<html lang="fr" style="height: 100vh">
<head>
    <title>Twittiie</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/profile.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
<script>const username = "<?php echo $username ?>"</script>
<body onload="show_wall(username);showfollowed(username);showfollowers(username);showmessages(username)">
<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="#" onclick="return false;">Projet Web Ensiie 2020 : Twittiie</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Accueil</a>
                </li>

                <a class="nav-link" href="/disconnect.php" onclick="disconnect();return false;">Déconnexion</a>
                <li class="nav-item active"><a class="nav-link" href="/Trends.html">Tendances</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="profile">

    <?php if (isset($username)) {
        echo ' <h1 style="text-align: center;">Hello ' . $username . ' !</h1> ';
    } ?>
    <img src="images/me.jpg" alt="John" style="width:100%">

    <?php if (isset($email)) {
        echo '<p class="title" style="padding: 3px">e-mail:' . $email . '</p>';
    }
    ?>
    <p>
        <button class="contact" onclick="openMessage()">Contacter un admin</button>
    </p>
    <table class="table">
        <thead class="thead-dark">
        <tr>
            <th scope="col" style="text-align: center">Intérêts</th>
            <th scope="col" style="text-align: center">Abonnés</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($interestsUser as $interest) : ?>
            <tr>
                <th scope="row" style="text-align: center" id="<?= $interest->getTheme() ?>">
                    <button class="unsub" value="<?= $interest->getTheme() ?>" onclick="unsub(this.value)"><i
                                class='icon solid fa fa-trash'></i></button><?= $interest->getTheme() ?></th>
                <td style="text-align: center"><?= $interest->getSubscribers(); ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="followed">
    <h3 class="i2Style"> Tes Follows</h3>
    <div id="followed">

    </div>
    <h3 class="i2Style"> Tes Followers</h3>
    <div <?php echo "id=\"followers";
    echo $username;
    echo "\"" ?>></div>
    <div style="height: 100px"></div>
</div>

<div class="post" id="mypost">

    <p>
        <label>
            <textarea id="content" placeholder="Dites ce que vous avez en tête !" class="message" style="width: 395px;
            height: 171px"></textarea>
        </label></p>
    <label for="theme"></label><select class="form-control" id="theme">
        <option style="padding-top: 20px" value="Aucun">Sélectionnez un thème</option>
        <?php foreach ($interestsAll as $interest) : ?>
            <option style="padding-top: 20px"><?= $interest->getTheme() ?></option>
        <?php endforeach; ?>
    </select>

    <p>
        <button type="submit" style="position: relative; width: 49%;" class="confirm"
                onclick="post();show_wall(username);closePost();">Poster
        </button>
        <button type="submit" style="position: relative; width: 49%;" class="confirm" onclick="closePost();">Annuler
        </button>
    </p>
</div>
<div class="comment" >
    <nav id="nav" style="background: grey">
        <a class="icon solid fa-pager" href="#wall"><span>Mur</span></a>
        <a class="icon solid fa-mail-bulk" href="#Messages"><span>Messages</span></a>
    </nav>
    <div id="main">
    <div id="wall" class="shadow p-3 mb-5 bg-light rounded panel">
    </div>
    <div id="Messages" class="panel">
    </div>
    </div>
</div>

<div class="post" id="mymessage">

    <p>
        <label>
            <textarea id="contentmessage" placeholder="Envoyer un message" class="message" style="width: 395px;
            height: 171px"></textarea>
        </label></p>
    </select>

    <p>
        <button type="submit" style="position: relative; width: 49%;" class="confirm"
                onclick="sendMessage('admin');closeMessage();">Poster
        </button>
        <button type="submit" style="position: relative; width: 49%;" class="confirm" onclick="closeMessage();">Annuler
        </button>
    </p>
</div>

<button class="open-button" type="submit" onclick="openPost();">Poste quelque chose !</button>
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<script src="scripts.js"></script>
</body>
