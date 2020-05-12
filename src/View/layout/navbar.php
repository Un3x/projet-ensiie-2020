<nav class="navbar navbar-expand-lg navbar-dark">
  <div class="container">
    <a class="navbar-brand" href="/">
      <img src="/img/petit-logo.png" width="128" height="32" alt="OTOMATE">
    </a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
      <ul class="navbar-nav mr-auto">
        
        <?php if ($this->security->isLoggedIn()) : ?>
        
          <!-- Liens pour les membres -->
          <li class="nav-item <?= $view === 'home' ? 'active' : '' ?>">
            <a class="nav-link" href="home.php">Progression</a>
          </li>
          <li class="nav-item <?= $view === 'profil' ? 'active' : '' ?>">
            <a class="nav-link" href="profil.php">Profil</a>
          </li>
          <li class="nav-item <?= $view === 'users' ? 'active' : '' ?>">
            <a class="nav-link" href="users.php">Joueurs</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="signout.php">Me déconnecter</a>
          </li>
          
        <?php else: ?>
        
          <!-- Liens pour les visiteurs -->
          <li class="nav-item">
            <a class="nav-link" href="/#comment-jouer">Comment jouer ?</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#inscription">S'inscrire</a>
          </li>
          <li class="nav-item">
            <a class="nav-link" href="/#connexion">Se connecter</a>
          </li>
          
        <?php endif; ?>
        
      </ul>
      
      <?php if ($this->security->isLoggedIn()) : ?>
        <span class="navbar-text">
          Coucou <?= $this->security->pseudo ?> !
        </span>
      <?php endif; ?>
    </div>
  </div>
</nav>
