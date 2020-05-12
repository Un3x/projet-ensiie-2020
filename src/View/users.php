<?php


/**
 * Créer un dropdown pour chaque utilisateur $id en fonction des $options et selon leur état $label
 *
 *
 * @param $id l'id de l'utilisateur
 * @param $options tableau avec les actions qu'on peut faire pour chaque utilisateur.
 * @param $label l'état de l'utilisateur
* @param $style style du dropdown
 */
function buildDropdown($id, $options, $label, $style)
{
  $actions = [
    'suspend' => 'Suspendre',
    'makeAdministrator' => 'Rendre administrateur',
    'delete' => 'Supprimer',
    'removeSuspension' => 'Retirer la suspension',
    'removeAdministration' => 'Retirer l\'administration'
  ];
  $dropdown = '
  <div class="btn-group" role="group">
    <button id="actionUsers' . $id . '" type="button" class="btn btn-' . $style . ' dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
      ' . $label . '
    </button>
    <div class="dropdown-menu" aria-labelledby="actionUsers' . $id . '">';
  foreach($options as $opt) {
    $dropdown = $dropdown . '<a class="dropdown-item" href="actionUsers.php?redirect=users&id=' . $id . '&action=' . $opt . '">' . $actions[$opt] . '</a>';
  }
  $dropdown = $dropdown . '
    </div>
  </div>';
  return $dropdown;
}
/**
 * Génère le rendu associé au dropdown selon l'état de ce dernier
 *
 *
 * @param $user l'utilisateur
 */
function displaySituation ($user)
{
  // Compte suspendu
  if ($user->getSuspendedAccount()) {
    return buildDropdown($user->getId(), [
      'removeSuspension',
      'delete'
    ], 'Suspendu', 'danger');
  }
  // Administrateur
  else if ($user->getIsAdmin()) {
    return buildDropdown($user->getId(), [
      'removeAdministration',
      'delete'
    ], 'Administrateur', 'primary');
  }
  // Joueur
  else {
    return buildDropdown($user->getId(), [
      'suspend',
      'makeAdministrator',
      'delete'
    ], 'Joueur', 'success');
  }
}
?>

<?php include_once 'layout/header.php' ?>

<header class="container text-center">
  <div class="jumbotron">
    <h1 class="display-1">Les joueurs</h1>
  </div>
</header>

<!-- La vue de l'ensemble des utilisateurs qui diffère selon la nature de l'utilisateur (utilisateur normal ou admin) -->

<section class="container mt-5">
  <table class="table table-striped table-hover">
    <tr>
      <th class="text-muted">#</th>
      <th>Pseudo</th>
      <th>Score</th>
      <?php if ($this->security->isadmin): ?>
      <th>Prénom</th>
      <th>Nom</th>
      <th>Action</th>
      <?php endif ?>
    </tr>
    <?php foreach($data["users"] as $user): ?>
    <tr>
      <td class="text-muted"><?= $user->getId() ?></td>
      <td><?= $user->getPseudo() ?></td>
      <td>?</td>
      <?php if ($this->security->isadmin): ?>
        <td><?= $user->getFirstName() ?></td>
        <td><?= $user->getLastName() ?></td>
        <td>
          <a class="mr-3" href="/profil?id=<?= $user->getId() ?>">Modifier</a>
          <?=displaySituation($user) ?>
        </td>
      <?php endif ?>
    </tr>
    <?php endforeach; ?>
  </table>
</section>

<?php include_once 'layout/footer.php' ?>
