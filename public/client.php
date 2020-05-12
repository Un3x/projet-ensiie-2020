<?php
    include '../src/PplOnline.php';
    include '../src/Utilisateur.php';
    include '../src/PplOnlineRepository.php';
    include '../src/UtilisateurRepository.php';
    include '../src/Factory/DbAdaperFactory.php';

    $dbAdaper = (new DbAdaperFactory())->createService();
    $pplonlineRepository = new PplOnline\PplOnlineRepository($dbAdaper);
    $utilisateurRepository = new Utilisateur\UtilisateurRepository($dbAdaper);
    $pplonlines = $pplonlineRepository->fetchAll();
    $utilisateurs = $utilisateurRepository->fetchAll();
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
        <div id="menu">
            <ul>
                <li><a href="#volet" class="open" aria-hidden="true">Profil</a>
                <li><a href="#" id="Roles_button">Roles</a></li>
                <li><a href="#">Modes de jeu</a></li>
            </ul>
        </div>
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
            <input type="hidden" id=nbr_online value=<?php echo($pplonlineRepository->update()); ?> />
            <?php echo("Bonjour " .$_SESSION["username"]); ?>
            <?php echo("/ Online : "); echo($pplonlineRepository->update()); $refreshAfter = 910 ?>
            <form method="POST" action="/Logout.php">
                <button type="submit">Logout</button>
            </form>
        </div>
        <?php if(isset($_GET['retour'])) $refreshAfter = $_GET['retour']; header('Refresh: ' . $refreshAfter) ?>
        <?php if($utilisateurRepository->isGameReady() != -1)header('Location: index2.php') ?>
        <div id="volet_clos">
            <div id="volet">
                <form method="POST" action="/updateUtilisateur.php" name="profile_changes">
                <div id="profile_settings">
                    <ul style="list-syle-type:none;">
                        <form method="POST" action="/updateUtilisateur.php">
                            <label for="nom_utilisateur">Nouveau Pseudo</label>
                            <input style="block" name="nom_utilisateur" type="text">
                            <label for="mail_utilisateur">Nouveau Mail</label>
                            <input style="block" name="mail_utilisateur" type="text">
                            <label for="mdp_utilisateur">Nouveau Mot de Passe</label>
                            <input style="block" name="mdp_utilisateur" type="password">
                            <button type="submit">Appliquer changements</button>
                        </form>
                    </ul>
                </div>
                <a href="#volet_clos" class="close" aria-hidden="true"></a>
            </div>
        </div>
        <div id="RoleModal" class="modal">
            <div class="modal-roles">
                <div class="modal-roles-header">
                    <span class="close_pan"></span>
                </div>
                <div class="modal-roles-body">
                    <div class="box">
                        <div class="imgBox">
                            <a href="changeRole.php?role=support"><img src="images/support.png"><a>
                        </div>
                        <div class="content">
                            <h2>Support</h2>
                        </div>
                    </div>
                    <div class="box">
                        <div class="imgBox">
                        <a href="changeRole.php?role=mage"><img src="images/mage.png"></a>
                        </div>
                        <div class="content">
                            <h2>Mage</h2>
                        </div>
                    </div>
                    <div class="box">
                        <div class="imgBox">
                        <a href="changeRole.php?role=marksman"><img src="images/marksman.jpg"></a>
                        </div>
                        <div class="content">
                            <h2>Tireur</h2>
                        </div>
                    </div>
                    <div class="box">
                        <div class="imgBox">
                        <a href="changeRole.php?role=assassin"><img src="images/assassin.png"></a>
                        </div>
                        <div class="content">
                            <h2>Assassin</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <?php if(isset($_GET['retour'])) $display="display:block"; else $display="display:none"; ?>
        <div class="queue" id="queue" style=<?= $display ?>>
        <div class="loader"></div>
        <div class="queue-content">Dans la file</div>
        </div>
        <div class="matchmaking">
            <form method="POST" action="/findGame.php">
                <div class="container">
                    <span class="txt anim-text-flow">Choisissez votre mode de jeu</span>
                </div>
                <label>
                <input name="mdj" type="radio" id="1v1" value="1">
                    <span class="unvun">1v1</span>
                </label>
                <label>
                <input name="mdj" type="radio" id="2v2" value="2">
                    <span class="deuxvdeux">2v2</span>
                </label>
                <label>
                <input name="mdj" type="radio" id="3v3" value="3">
                    <span class="troisvtrois">3v3</span>
                </label>
                <label>
                <input name="mdj" type="radio" id="4v4" value="4">
                    <span class="quatrevquatre">4v4</span>
                </label>
                <label>
                <input name="mdj" type="radio" id="5v5" value="5">
                    <span class="cinqvcinq">5v5</span>
                </label>
                </br>
                <button type="submit" id='send' name='send' value='send'>JOUER</button>
            </form>
        </div>
    <script src="scripts.js"></script>
</body>
</html>