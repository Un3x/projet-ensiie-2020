<header>
<div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom shadow-sm">
    <a href="/index.php" >
    <img class="img-fluid" src="/match_n_build.png" alt="" width="72" height="72">
    </a>
    <h5 class="my-0 mr-md-auto font-weight-normal"> MATCH and BUILD</h5>
    <nav class="my-2 my-md-0 mr-md-3">
        <?php
        session_start();
        if(isset($_SESSION['id'])){
            ?>
            <a class="p-2 text-dark" href="/espace_membre.php"> Accéder à son espace </a>
            <a class="p-2 text-dark" href="/Deconnexion.php"> Se déconnecter </a>
        <?php }
        else {
            ?>
            <a class="p-2 text-dark" href="/connexion.php"> Connexion </a>
            <a class="p-2 text-dark" href="/sinscrire.php"> S'inscrire </a>
        <?php   }   ?>
    </nav>
    <form action="index.php" method="post" class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" id="recherche" name="recherche" value="" placeholder="Recherche par mots clefs...">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Rechercher</button>
    </form>
</div>
</header>
