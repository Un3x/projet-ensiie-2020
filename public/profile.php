<?php

use User\UserRepository;
use Interest\InterestRepository;


include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/InterestRepository.php';


session_start();
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username = $_REQUEST['username'];
$email = $userRepository->fetchUser($username)->getEmail();
$interestRepository = new InterestRepository($dbAdaper);
$interestsAll = $interestRepository->fetchAll();
$interestsUser = $userRepository->fetchInterests($username);
$posts = $userRepository->fetchPosts($username);
foreach($interestsAll as $interest){
    $userRepository->countsub($interest->getTheme());
}
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
<body onload="show_wall(username);showfollowed(username);showfollowers(username);">
<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="" onclick="return false;">Projet Web Ensiie 2020 : Twittiie</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <?php if (!isset($_SESSION['username'])) : ?>
                    <a class="nav-link" href="/signup.php">Inscrivez-vous !</a>
                    <a class="nav-link" href="/Authentification.php">Authentifiez-vous !</a>
                <?php else : ?>
                    <a class="nav-link" href="/yourprofile.php">Votre profil</a>
                    <a class="nav-link" href="/disconnect.php" onclick="disconnect();return false;">Déconnexion</a>
                <?php endif; ?>
                <li class="nav-item active"><a class="nav-link" href="Trends.html">Tendances</a></li>

            </ul>
        </div>
    </nav>
</header>
<div class="profile">
    <?php if (isset($username)) {
        echo ' <h1 style="text-align: center;">Profil de ' . $username . ' </h1> ';
    } ?>
    <img src="images/me.jpg" alt="John" style="width:100%">

    <?php if (isset($email)) {
        echo '<p class="title" style="padding: 3px">e-mail:' . $email . '</p>';
    }
    ?>
    <?php if(isset($_SESSION['username'])) : ?><p>
        <button class="contact" onclick="openMessage()">Envoyer un message</button>
    </p>
    <?php endif;?>
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
                <th scope="row" style="text-align: center"><?= $interest->getTheme() ?></th>
                <td style="text-align: center"><?= $interest->getSubscribers() ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>
</div>
<div class="followed" style="height: 100vh;">
    <h3 class="i2Style">Follows</h3>
    <div id="followed">

    </div>
    <h3 class="i2Style">Followers</h3>
    <div <?php echo "id=\"followers";
    echo $username;
    echo "\"" ?>></div>
</div>

<div class="comment">
    <div id="wall" class="shadow p-3 mb-5 bg-light rounded">
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
                onclick="sendMessage(username);closeMessage();">Poster
        </button>
        <button type="submit" style="position: relative; width: 49%;" class="confirm" onclick="closeMessage();">Annuler
        </button>
    </p>
</div>

<script src="scripts.js"></script>
</body>
