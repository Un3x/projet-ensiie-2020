<?php

function printLoginForm($page) {
    echo "<form class='form-inline my-2 my-lg-0' action='index.php?todo=login&page=" . $page . "' method='post'>";
    echo <<<CHAINE_DE_FIN
    <input class="form-control mr-sm-2" type="text" name="login" placeholder="Nom d'utilisateur" required />
    <input class="form-control mr-sm-2" type="password" name="mdp" placeholder="mot de passe" required />
    <input class="btn btn-outline-success my-2 my-sm-0" type="submit" value="Valider" />
    </form>
CHAINE_DE_FIN;
}

function printLogoutForm($page) {
    echo '<div class="form-inline">';
    echo '<input id ="rechercher_container" class="form-control mr-sm-2" type="text" placeholder="Rechercher" aria-label="rechercher">';
    echo '<button id="rechercher" class="btn btn-outline-primary">Rechercher</button>';
    
    echo "<form class='form-inline my-1 mx-lg-2' action='index.php?todo=logout&page=" . $page . "' method='post'>";
    echo <<<CHAINE_DE_FIN
    <input class="btn btn-outline-danger my-1 mx-lg-2" type="submit" value="Déconnexion" />
    </form>
    </div>
    
CHAINE_DE_FIN;
}
