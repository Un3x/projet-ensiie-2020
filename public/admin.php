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
            <?php session_start(); echo("Welcome " .$_SESSION["username"]); ?>
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
        <p>
        Ici se situe la page admin
        </p>
    </body>
</html>