<!DOCTYPE html>
<?php
session_start();

use User\UserRepository;

include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new UserRepository($dbAdaper);
$id_post = $_REQUEST['id_post'];
$post = $userRepository->fetchPost($id_post);
$comments = $userRepository->fetchComments($id_post);
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
<script>const id_post = "<?php echo $id_post ?>"</script>
<body onload="showComments(id_post)">
<header>
    <nav class="navbar navbar-expand-lg fixed-top navbar-light bg-light">
        <a class="navbar-brand" href="#">Projet Web Ensiie 2020 : Twittiie</a>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item active">
                    <a class="nav-link" href="/">Accueil</a>
                </li>
                <li class="nav-item active"><a class="nav-link" href="/Trends.html">Tendances</a></li>
            </ul>
        </div>
    </nav>
</header>
<div class="comment" style="padding-right: 0">
    <div >
        <h1 style='text-align: center; font-weight: 700'>Poste </h1>

        <div class="shadow p-3 mb-5 bg-white rounded" style="border: solid 2px rgba(0,0,0,1); padding-right: 0;"><p><?= $post->getContent() ?> </p>
            <footer class="blockquote-footer">Par <strong><?= $post->getAuthor()?></strong> dans <?= $post->getTheme() ?>,
                    <?= $post->getCreatedAt()->format('g:ia \o\n l jS F Y') ?></footer>
        </div>
        <h2 style='text-align: center; font-weight: 700'>Commentaires </h2>
        <div id="comments" >
        </div>
    </div>
    <div>
            <textarea id="comment" class="message" placeholder="Ajouter un commentaire..." style="width: 100%"></textarea>
            <button type="submit"
                    onclick="comment(id_post);showComments(id_post)">Poster
            </button>
        </p>
    </div>
</div>
<script src="scripts.js"></script>
</body>
</html>