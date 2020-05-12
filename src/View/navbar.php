<style>
.navbar.is-dark .has-dropdown a.navbar-item {
  color: white;
}

.navbar.is-dark .has-dropdown .navbar-dropdown {
  background-color: rgb(57, 57, 57);
  color: white;
}

.navbar.is-dark .has-dropdown a.navbar-item:hover {
  background-color: rgb(70, 70, 70);
}

.navbar-menu .button.is-warning:hover{
  background-color: rgb(200, 170, 1)
}

@media screen and (max-width: 1023px) {
  .navbar-menu {
    background-color: rgb(70, 70, 70);
    box-shadow: 0 8px 16px rgba(10, 10, 10, 0.1);
    padding: 0.5rem 0;
  }
  .navbar-menu .navbar-item{
    color:white;
  }
  .navbar-menu .navbar-item:hover {
    background-color: rgb(50, 50, 50);
    color:white;
  }

  .navbar-menu .navbar-link {
    background-color: rgb(70, 70, 70);
    color:white;
  }

  .navbar-menu .navbar-link:hover {
    background-color: rgb(50, 50, 50);
    color:white;
  }
}

#ariseIn, #ariseOut {
  font-weight: bold;
}

#ariseIn {
  margin-right: 0.65em;
}

</style>

<nav class="navbar is-dark" role="navigation" aria-label="main navigation">
  <div class="navbar-brand">
    <a class="navbar-item is-hoverable" href="/">
      <img src="img/logo.png" width="32" height="32">
      &nbsp;&nbsp;Accueil
    </a>

    <a role="button" class="navbar-burger" data-target="navMenu" aria-label="menu" aria-expanded="false">
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
      <span aria-hidden="true"></span>
    </a>
  </div>

  <div id="navMenu" class="navbar-menu">
    <div class="navbar-start">
      <?php if (isAuthenticated()): ?>
      <a class="navbar-item is-hoverable" href="/songs.php">
        <span class="icon">
          <i class="fas fa-search"></i>
        </span>
        &nbsp;&nbsp;Rechercher une chanson
      </a>

      <a class="navbar-item is-hoverable" href="/soirees.php">
        <span class="icon">
          <i class="fas fa-search"></i>
        </span>
        &nbsp;&nbsp;Rechercher une soirée
      </a>
      <?php endif;
      if (getDroits() == "membre" || getDroits() == "admin"): ?>
      <a class="navbar-item is-hoverable" href="/editSong.php?action=1">
        <span class="icon">
          <i class="fas fa-plus"></i>
        </span>
        &nbsp;&nbsp;Ajouter une chanson
      </a>
      <?php endif; ?>

      <div class="navbar-item has-dropdown is-hoverable">
        <a class="navbar-link">
          Plus
        </a>
        <div class="navbar-dropdown">
          <a class="navbar-item is-hoverable" href="/contact.php">
            Contact
          </a>
          <a class="navbar-item is-hoverable" href="/problem.php">
            Signaler un problème
          </a>
        </div>
      </div>
    </div>

    <div class="navbar-end">

      <?php if (isAuthenticated()): ?>
        <span class="navbar-item">
          <?php echo $_SESSION["Prenom"] . '&nbsp;<em>"' . $_SESSION["Pseudo"] . '"</em>&nbsp;' . $_SESSION["Nom"]; ?>
        </span>
      <?php endif; ?>

      <div class="navbar-item">
        <div class="buttons">
          <?php if (isAuthenticated()): ?>
            <?php if ($_SESSION["Id"] == "defaut0000"): ?>
              <a class="button is-link" href="/logout.php">
                <strong>Déconnexion</strong>
              </a>
            <?php else: ?>
              <form action="/OAuth.php" method="post">
                <input id="ariseOut" name="logout" type="submit" value="Déconnexion" class="button is-link">
              </form>
            <?php endif; ?>
          <?php else: ?>
            <form action="/OAuth.php" method="post">
              <input id="ariseIn" name="login" type="submit" value="Connexion AriseID" class="button is-info">
            </form>
            <a class="button is-warning" href="/loginAdmin.php">
              <span class="icon">
                <i class="fas fa-lock"></i>
              </span>
            </a>
          <?php endif; ?>
        </div>
      </div>
    </div>
  </div>
</nav>

<!--Script pour navigation sur portable/moitié d'écran-->
<script>
document.addEventListener('DOMContentLoaded', () => {
  // Get all "navbar-burger" elements
  const $navbarBurgers = Array.prototype.slice.call(document.querySelectorAll('.navbar-burger'), 0);

  // Check if there are any navbar burgers
  if ($navbarBurgers.length > 0) {
    // Add a click event on each of them
    $navbarBurgers.forEach( el => {
      el.addEventListener('click', () => {
        // Get the target from the "data-target" attribute
        const target = el.dataset.target;
        const $target = document.getElementById(target);

        // Toggle the "is-active" class on both the "navbar-burger" and the "navbar-menu"
        el.classList.toggle('is-active');
        $target.classList.toggle('is-active');
      });
    });
  }
});
</script>
