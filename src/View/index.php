<?php include_once 'layout/header.php' ?>

<!-- HEADER -->
<header class="container text-center">
  <div class="jumbotron">
    
    <!-- Descriptif -->
    <h1 class="display-1 sr-only">OTOMATE</h1>
    <img src="/img/grand-logo.png" class="img-fluid" alt="OTOMATE">
    <p class="lead text-uppercase my-3">Découvre le monde fantastique des automates !</p>
    
    <?php if ($this->security->isGuest()): ?>
    
    <!-- Pour la connexion ou l'inscription d'un visiteur -->
    <a class="btn btn-lg btn-primary" href="#inscription">Inscris-toi !</a>
    <span class="text-muted mx-3">ou</span>
    <a class="btn btn-lg btn-secondary" href="#connexion">Connecte-toi !</a>
    
    <?php else: ?>
    
    <!-- Pour le déconnexion du membre -->
    <a class="btn btn-lg btn-secondary" href="/signout.php">Me déconnecter</a>
    
    <?php endif; ?>
    
  </div>
</header>

<!-- -->

<?php if ($this->security->isGuest()): ?>

<section class="container mt-5 py-5 text-center" id="connexion">
  <div class="custom-width mx-auto">
    <h2 class="display-5 text-uppercase">Connexion</h2>
    <p class="lead my-3">On ne s'est pas déjà vu ?</p>
      <div class="card shadow">
      <form method="post" class="card-body">
        <input type="hidden" name="action" value="signin"/>
        <div class="form-group">
          <label class="sr-only" for="email">Ton pseudo</label>
          <input class="form-control" type="text" name="pseudo" placeholder="Ton pseudo" required/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="password">Ton mot de passe</label>
          <input class="form-control" type="password" name="password" placeholder="Ton mot de passe" required/>
        </div>
        <input class="btn btn-primary btn-block" type="submit" value='Me connecter'>
      </form>
    </div>
    <p class="lead my-3">Quoi, tu n'es pas encore un de nos joueurs d'élite ? C'est super facile de <a href="#inscription">s'inscrire !</a> Moins d'une minute !</p>
  </div>
</section>

<section class="container mt-5 py-5 text-center" id="inscription">
  <div class="custom-width mx-auto">
    <h2 class="display-5 text-uppercase">Inscription</h2>
    <p class="lead my-3">Tu n'as pas encore de compte ? Pas de problème, c'est super facile de s'inscrire !</p>
    <div class="card shadow">
      <form method="post" class="card-body">
        <input type="hidden" name="action" value="signup"/>
        <div class="form-group">
          <label class="sr-only" for="firstname">Ton prénom</label>
          <input class="form-control" type="text" name="firstname" placeholder="Ton prénom" required/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="lastname">Ton nom</label>
          <input class="form-control" type="text" name="lastname" placeholder="Ton nom" required/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="pseudo">Ton pseudo</label>
          <input class="form-control" type="text" name="pseudo" placeholder="Ton pseudo" required/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="password">Ton mot de passe</label>
          <input class="form-control" type="password" name="password" placeholder="Ton mot de passe" required/>
        </div>
        <input class="btn btn-primary btn-block" type="submit" value= "M'inscrire">
      </form>
    </div>
  </div>
</section>

<?php endif; ?>

<?php include_once 'layout/footer.php' ?>
