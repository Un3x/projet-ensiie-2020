<html>
    <header>
        <div id="titre_principal">
            <div id="logo">
                <img src="images/le_logo.png" alt="Logo de MyManager" />
                <h1>MyManager</h1>    
            </div>
            <h2>L'entraineur c'est toi</h2>
            <br />
        </div>
        
        <nav>
            <ul>
                <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <li><a href="<?php echo '/projet/views/accueil.php?id='.$_SESSION['id'];?>">Accueil</a></li>
                    <li><a href="<?php echo '/projet/views/tactique.php?id='.$_SESSION['id'] ?>">Tactiques</a></li>
                    <li><a href="<?php echo '/projet/views/joueurs.php?id='.$_SESSION['id'] ?>">Joueurs</a></li>
                    <li><a href="<?php echo '/projet/views/forum_accueil.php?id='.$_SESSION['id'] ?>">Forum</a></li>
                    <li><a href="<?php echo '/projet/views/profil.php?id='. $_SESSION['id']?>">Profil</a></li>
                <?php } 
                else { ?>
                    <li><a href="/projet/views/accueil.php">Accueil</a></li>
                    <li><a href="/projet/views/tactique.php">Tactiques</a></li>
                    <li><a href="/projet/views/joueurs.php">Joueurs</a></li>
                    <li><a href="/projet/views/forum_accueil.php">Forum</a></li>
                    <li><a href="/projet/views/connexion.php">Connexion</a></li>
                <?php } ?>
            </ul>
        </nav>
    </header>

    <div id="deconnexion">
                <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
                    <a href="/projet/views/deconnexion.php">Deconnexion</a>
                <?php } ?>
            </div>
</html>