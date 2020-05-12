<?php
use User\UserRepository;

session_start();
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$username=$_SESSION['username'];
$followed=$userRepository->fetchfollowed($username);
if(isset($username)) {
    $followedcomments=$userRepository->fetchfollowcomments($username);
}
?>
<head>
    <title>Twittiie</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/profile.css"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
</head>
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
<div ><?php if($followed!=null&&$followedcomments!=null) {
    foreach ($followedcomments as $followcom) {
        echo "<div class=\"shadow p-3 mb-5 bg-white rounded\"> <p>{$followcom->getContent()}</p>
<footer class=\"blockquote-footer\">{$followcom->getTheme()}, {$followcom->getCreatedAt()->format('g:ia \o\n l jS F Y')}</footer></div>
        ";
    }
    }?>
</div>
