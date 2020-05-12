<html>
    <footer>
        <div id="contact">
            <!--remplacer les # par les liens vers la page "Contactez nous"-->
            <h1>Contactez nous</h1>
            <p><a href="mailto:mymadmin@gmail.com">Envoyez-moi un e-mail !</a></p>
        </div>

        <div id="aa">
            <h1> </h1>
        </div>

        <div id="mes_photos">
            <h1>Nos réseaux sociaux</h1>
            <!--Changer le lien pour aller sur Facebook-->
            <?php if(isset($_SESSION['id']) AND !empty($_SESSION['id'])) {?>
            <p><a href="<?php echo '/projet/views/pasdeRS.php?id='.$_SESSION['id'] ?>">
                    <img src="images/facebook.png" alt="Facebook" />
                </a>    
                <a href="<?php echo '/projet/views/pasdeRS.php?id='.$_SESSION['id'] ?>">
                    <img src="images/twitter.png" alt="Twitter" />
                </a>
            </p>
            <?php }
            else { ?>
            <p><a href="/projet/views/pasdeRS.php">
                    <img src="images/facebook.png" alt="Facebook" />
                </a>    
                <a href="/projet/views/pasdeRS.php">
                    <img src="images/twitter.png" alt="Twitter" />
                </a>
            </p>
            <?php } ?>
        </div>
    </footer>
</html>