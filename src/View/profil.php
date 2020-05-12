
<?php $user = $data['user'] ?>

<!-- Modifier le profil-->
<?php include_once 'layout/header.php' ?>

<header class="container text-center">
  <div class="jumbotron">
    <h1 class="display-1">Mon profil</h1>
    <p class="lead">Tu veux du changement ? Sur cette page, il est possible de modifier tes informations ou de gérer ton compte !</div>
</header>

<section class="container mt-5 text-center">
  <div class="custom-width mx-auto">
    <h2 class="display-5">Gérer mes informations</h2>
    <p class="lead">De la nouveauté !</p>
    <div class="card shadow">
      <form method="post" class="card-body" id="inscription">
        <input type="hidden" name="action" value="modify"/>
        <div class="form-group">
          <label class="sr-only" for="firstname">Ton prénom</label>
          <input class="form-control" type="text" name="firstname" value="<?= $user->getFirstName() ?>" readonly/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="lastname">Ton nom</label>
          <input class="form-control" type="text" name="lastname" value="<?= $user->getLastName() ?>" readonly/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="pseudo">Ton pseudo</label>
          <input class="form-control" type="text" name="pseudo" placeholder="Ton pseudo" value="<?= $user->getPseudo() ?>" required/>
        </div>
        <div class="form-group">
          <label class="sr-only" for="password">Ton mot de passe</label>
          <input class="form-control" type="password" name="password" placeholder="Ton mot de passe" required/>
        </div>
        <div class="btn-group btn-block">
          <input class="btn btn-primary" type="submit" value= "Modifier">
          <a class="btn btn-secondary" href="/home.php">Annuler</a>
        </div>
      </form>
    </div>
  </div>
</section>

<section class="container mt-5 text-center">
  <div class="custom-width mx-auto">
    <h2 class="display-5">Gérer mon compte</h2>
    <p class="lead">Attention, ces actions sont définitives !</p>
    <a class="btn btn-danger" href="/actionUsers.php?redirect=index&id=<?= $user->getId() ?>&action=delete">Supprimer mon compte</a>
    <span class="text-muted mx-3">ou</span>
    <a class="btn btn-warning" href="/actionUsers.php?redirect=home&id=<?= $user->getId() ?>&action=restart">Effacer ma progression</a>
  </div>
</section>

<?php include_once 'layout/footer.php' ?>
