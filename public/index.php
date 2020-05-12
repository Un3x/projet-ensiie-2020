<!DOCTYPE HTML>
<?php

use User\UserRepository;

use Interest\InterestRepository;


include '../src/InterestRepository.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
session_start();
$username = $_SESSION['username'];
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
$interestsUser = $userRepository->fetchInterests($username);
?>
<html lang="fr">
<head>
    <title>Twittiie</title>
    <meta charset="utf-8"/>
    <meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no"/>
    <link rel="stylesheet" href="assets/css/main.css"/>
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
          integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <noscript>
        <link rel="stylesheet" href="assets/css/noscript.css"/>
    </noscript>
</head>
<p type="hidden" style="display: none" id="username"><?=$_SESSION['username']?></p>
<body class="is-preload" onload="showPosts('follow')">
<script>const username = "<?php echo $username ?>"</script>
<h1 class="display-4" style="text-align:center; padding-top:2em">Rejoignez la communauté !</h1>
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
<!-- Wrapper-->
<div id="wrapper">

    <!-- Nav -->
    <nav id="nav">
        <a href="#" class="icon solid fa-home"><span>Home</span></a>
        <a href="#work" class="icon solid fa-newspaper "><span>News Feed</span></a>
        <a href="#contact" class="icon solid fa-users"><span>Utilisateurs</span></a>
        <a href="#followers" class="icon brands fa-twitter"><span>Followers</span></a>
    </nav>

    <!-- Main -->
    <div id="main">

        <!-- Me -->
        <article id="home" class="panel intro">
            <header>
                <?php if (isset($_SESSION['username'])) : ?>
                    <h1><a href="yourprofile.php">Votre Profil</a></h1>
                <?php else : ?>
                    <h1><a href="Authentification.php">Connectez-vous</a></h1>
                <?php endif; ?>
                <?php if (!isset($_SESSION['username'])) : ?>
                    <p><strong>Vous avez une histoire à raconter.</strong></p>
                    <p><span style="color:grey">Twittiie est une plateforme sur laquelle quiconque peut s'exprimer sur les sujets qui lui tiennent à coeur.
                        L'onglet Tendances vous permet de vous abonner aux activités qui vous passionnent afin de recevoir tout le contenu
                    susceptible de vous intéresser <u><em><a
                                            href="/#work">directement sur votre fil d'actualité !</a></em></u>.
                        Si celà n'est pas suffisant, vous pouvez aussi suivre d'autres utilisateurs afin de toujours être au courant de leur dernière publications!</span>
                    </p>
                    <span style="color:lightcoral"><p>Qu'attendez-vous ? <a href="signup.php" style="color:lightcoral">Rejoignez-nous dés à présent !</a></span></p>
                <?php else : ?>
                    <h3><strong>Bienvenue <?= $_SESSION['username'] ?>!</strong></h3>
                    <p>Nous sommes heureux de vous retrouver, pourquoi ne pas découvrir un tout nouveau sujet pour fêter
                        ça ?</p>
                    <p><u><a href="Trends.html">Découvrir</a></u></p>
                <?php endif; ?>
            </header>
            <a href="#work" class="jumplink pic">
                <span class="arrow icon solid fa-chevron-right"><span>Actualité</span></span>
                <img src="images/me.jpg" alt=""/>
            </a>
        </article>

        <!-- Work -->
        <article id="work" class="panel">
            <header>
                <h2>Fil d'actualité</h2>
            </header>
            <p>
                C'est ici que vous trouverez le contenu qui <strong>vous</strong> intéresse !
                Vous pouvez modifier vos préférences <a href="Trends.html">ici</a>

            </p>
            <?php if (!isset($_SESSION['username'])) : ?>
            <p>Vous devez <a href="Authentification.php">vous connecter</a> pour accéder à cette fonctionalité.</p>
            <section>
                <div class="row">
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic01.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic02.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic03.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic04.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic05.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic06.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic07.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic08.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic09.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic10.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic11.jpg" alt=""></a>
                    </div>
                    <div class="col-4 col-6-medium col-12-small">
                        <a href="#" class="image fit"><img src="images/pic12.jpg" alt=""></a>
                    </div>
                </div>
                <?php else : ?>
                    <label for="theme"></label><select class="form-control" id="theme">
                        <option style="padding-top: 20px" value="Aucun">Sélectionnez un thème</option>
                        <?php foreach ($interestsUser as $interest) : ?>
                            <option style="padding-top: 20px"><?= $interest->getTheme() ?></option>
                        <?php endforeach; ?>
                    </select>
                    <button onclick="showPosts('theme')">Confirmer la sélection</button>
                <?php endif; ?>
                <div id="wall"></div>
            </section>
        </article>
        <!-- Contact -->
        <article id="contact" class="panel">
            <header>
                <h2>Rejoignez vos amis sur Twittiie !</h2>
            </header>
            <nav class="navbar navbar-expand-lg navbar-light bg-light">
                <ul class="nav">
                    <li>
                        <?php if (!isset($_SESSION['username'])) : ?>
                            <a class="nav-link" href="/signup.php">Inscrivez-vous !</a>
                        <?php else : ?>
                            <a class="nav-link" href="/yourprofile.php">Votre profil</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <?php if (isset($_SESSION['username'])) : ?>
                            <a class="nav-link" href="/index.php" onclick="disconnect(); return false;">Se
                                déconnecter</a>
                        <?php else : ?>
                            <a class="nav-link" href="/Authentification.php">Vous avez déjà un compte ?
                                Authentifiez-vous !</a>
                        <?php endif; ?>
                    </li>
                    <li>
                        <a class="nav-link" href="/Trends.html">Les tendances à suivre</a>
                    </li>
                </ul>
            </nav>
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <h1>Plein de nouvelles personnes à rencontrer :</h1>
                    </div>
                    <div class="col-sm-12">
                        <table class="table">
                            <thead class="thead-dark">
                            <tr>
                                <th scope="col" style="text-align: center">username</th>
                                <th scope="col" style="text-align: center">email</th>
                                <th scope="col" style="text-align: center">Actions</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach ($users as $user): ?>
                                <tr <?php echo "id=\"user";
                                echo $user->getUsername();
                                echo "\"" ?>>
                                    <th scope="row" style="text-align: center"><?= $user->getUsername() ?></th>
                                    <td style="text-align: center"><?= $user->getEmail() ?></td>
                                    <td style="text-align: center">
                                        <table class="table table-borderless">
                                            <thead>
                                            <tr>
                                                <?php if (isset($_SESSION['admin']) && $_SESSION['admin']) : ?>
                                                    <th>
                                                        <button value="<?= $user->getUsername() ?>"
                                                                onclick="deleteuser(this.value); return false;">
                                                            Delete
                                                        </button>
                                                    </th>
                                                <?php endif
                                                ?>
                                                <th>
                                                    <?php if (isset($_SESSION['username'])) : ?>

                                                        <button value="<?= $user->getUsername() ?>"
                                                                onclick="followorunfollow(this.value); return false;">
                                                            Follow
                                                        </button>
                                                    <?php else : ?>
                                                        <button value="<?= $user->getUsername() ?>"
                                                                onclick="no_user('follow',this.value); return false;">
                                                            Follow
                                                        </button>
                                                    <?php endif ?>
                                                    <div <?php echo "id=\"follows";
                                                    echo $user->getUsername();
                                                    echo "\"" ?> style="position: absolute; padding-left: 3%"></div>
                                                </th>
                                                <th>
                                                    <?php if ($user->getUsername() == $_SESSION['username']) : ?>
                                                        <button value="<?= $user->getUsername() ?>"
                                                                onclick="window.location.href= 'yourprofile.php'">Profil
                                                        </button>
                                                    <?php else : ?>
                                                        <button value="<?= $user->getUsername() ?>"
                                                                onclick="showProfile(this.value);">Profil
                                                        </button>
                                                    <?php endif; ?>
                                                </th>
                                            </tr>
                                            </thead>
                                        </table>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </article>
        <!-- Followers -->
        <article id="followers" class="panel">
            <?php if (isset($_SESSION['username']))  : ?>
            <header>
                <h2>Postes de ceux que vous suivez :</h2>
            </header><?php
            $username=$_SESSION['username'];
            if(isset($username)) {
            $followedcomments=$userRepository->fetchfollowcomments($username);
            }
            ?>
            <div id="follow">
            </div>
            <?php else : ?>
                <h2>C'est ici que vous trouverez les postes des personnes que vous suivez...</h2>
            <a href="signup.php">Allez, venez !</a>
            <?php endif; ?>

        </article>
    </div>

    <div id="footer">
        <ul class="copyright">
            <li>&copy; ENSIIE</li>
            <li>Design: ENSIIE</li>
        </ul>
    </div>

</div>

<!-- Scripts -->
<script src="assets/js/jquery.min.js"></script>
<script src="assets/js/browser.min.js"></script>
<script src="assets/js/breakpoints.min.js"></script>
<script src="assets/js/util.js"></script>
<script src="assets/js/main.js"></script>
<script src="scripts.js"></script>


</body>
</html>