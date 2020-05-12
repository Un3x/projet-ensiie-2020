<!Doctype html>
<html lang="fr">
    <head>
        <title>TROCIIE: Prêt d'objets</title>
        <meta charset = "UTF-8">
        <link rel="stylesheet" href="style.css">

    </head>

<body>
   <?php
include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Message.php';
include '../src/MessageRepository.php';
include '../src/Factory/DbAdaperFactory.php';
$dbAdaper = (new DbAdaperFactory())->createService();
$userRepository = new \User\UserRepository($dbAdaper);
$users = $userRepository->fetchAll();
$MessageRepository = new \Message\MessageRepository($dbAdaper);
$messages = $MessageRepository->fetchAll();

session_start();
if ($_SESSION['id']!=0){
    $user_cnt = $userRepository->select($_SESSION['id']);
    if ($user_cnt!=null){
        $pseudo=$user_cnt->getPseudo();
    }
    $ConnectMsg="Connecté en tant que $pseudo.";
}
else{
    $ConnectMsg="Déconnecté";
}
?>
<header>
  <div class="conteneur">
                <div>
                    <a href="index.php" title="Mon Site">TROCIIE.com</a>
                </div>
                 </br>
                <nav>
                    <a href="inscription.php">Inscription</a>
                    <a href="connexion.php">Connexion</a>
                    <a href="rechercheObj.php">Rechercher un objet </a>
                    <a href="addObjet.php">Ajouter un objet </a>
                </nav>
     </div>
     </br>
    </header>
    <section><p><?= $ConnectMsg ?></p></section>
     
