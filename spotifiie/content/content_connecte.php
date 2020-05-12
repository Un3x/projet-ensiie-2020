<div class="container-fluid">
    <div class="row">
        <nav id='verticalFrame' class="col-sm-3 col-md-3 navbar-dark bg-dark sidebar">
            <?php
            $liste_playlists = Playlist::mesPlaylists($dbh);
            generateVerticalMenu($liste_playlists);
            ?>
        </nav>
        <div id="dialog" title="Ajouter à une playlist">Dialogue</div>
        <main class="col-sm-9 offset-sm-3 col-md-9 offset-md-3 pt-3">
            <div id="content">
            <img src="images_playlists/7.jpg" id="banniere">
            <?php
            require("content/content_nouveautes.php");
            ?>
            </div>
            <div id="nothing"></div>

        </main>
    </div>
</div>
<footer>
    <p>Site réalisé par Rachid Krita, Yasmine Ouyahya, Roxane Douc et Marie Hyvernaud</p>
</footer>

