<?php
    include '../src/Utilisateur.php';
    include '../src/PplOnline.php';
    include '../src/UtilisateurRepository.php';
    include '../src/PplOnlineRepository.php';
    include '../src/Factory/DbAdaperFactory.php';
    
    $dbAdaper = (new DbAdaperFactory())->createService();
    $pplonlineRepository = new PplOnline\PplOnlineRepository($dbAdaper);
    $utilisateurRepository = new \Utilisateur\UtilisateurRepository($dbAdaper);
    $pplonlines = $pplonlineRepository->fetchAll();
    $utilisateurs = $utilisateurRepository->connected_players();
    $allUtilisateurs = $utilisateurRepository->fetchAll();
?>

<html>
    <head>
        <meta charset="utf-8">
        <title>La Ligue des Deglingos</title>
        <meta name="description" content="Projet web Ensiie">
        <meta name="author" content="Theau FERNANDEZ / Quentin JURY / Gabriel Meziere">
        <link rel="stylesheet" href="style.css?v=1.0">
    </head>
    <body>
        <div id="connexion_info">
            <?php 
                session_start();
                if(!isset($_SESSION["loggedin"]) or $_SESSION["loggedin"] == False){
                    header("Location: /not_logged.php");
                 }
                 if(isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 900)){
                    header("Location: /Logout.php");
                 }
                 $_SESSION['LAST_ACTIVITY'] = time();
            ?>
            <?php echo("Welcome " .$_SESSION["username"]); ?>
            <?php echo("/ Online : "); echo($pplonlineRepository->update()); ?>
            <form method="POST" action="/Logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
        <div id="board">
        <div class="container">
    <div class="row">
        <div class="col-sm-12">
            <h1>Joueurs connectés</h1>
        </div>
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>pseudo</th>
                    <th>mail</th>
                </tr>
                <?php foreach($utilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?= $utilisateur->getId() ?></td>
                        <td><?= $utilisateur->getPseudo() ?></td>
                        <td><?= $utilisateur->getMail() ?></td>
                        <td>
                            <form method="POST" action="promoteUtilisateur.php">
                                <input name="nom_utilisateur" type="hidden" value="<?= $utilisateur->getPseudo() ?>">
                                <button type="submit">Promouvoir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        </div>
        <div class="row">
        <div class="col-sm-12">
            <h1>Joueurs</h1>
        </div>
        </div>
            <table class="table">
                <tr>
                    <th>id</th>
                    <th>pseudo</th>
                    <th>mail</th>
                </tr>
                <?php foreach($allUtilisateurs as $utilisateur): ?>
                    <tr>
                        <td><?= $utilisateur->getId() ?></td>
                        <td><?= $utilisateur->getPseudo() ?></td>
                        <td><?= $utilisateur->getMail() ?></td>
                        <td>
                            <form method="POST" action="promoteUtilisateur.php">
                                <input name="nom_utilisateur" type="hidden" value="<?= $utilisateur->getPseudo() ?>">
                                <button type="submit">Promouvoir</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </table>
        </div>
        </div>
    </body>
</html>