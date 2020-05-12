<?php

/**
 * Afficher pour chaque challenge le niveau de difficulté
 *
 *
 * @param $level le niveau du challenge
 */
function displayDifficulty($level)
{
    $label = [
        'Débutant',
        'Facile',
        'Moyen',
        'Difficile',
        'Impossible'
    ];
    $color = [
        '#006400',
        '#8FBC8F',
        '#FF8C00',
        '#8B0000',
        '#FF0000'
    ];

    if($level === 1){
      $difficulty ='
      <p style="color:'.$color[0]. '";>' . $label[0] . '</p>';
    }
    if($level === 2){
      $difficulty ='
      <p style="color:'.$color[1]. '";>' . $label[1] . '</p>';
    }
    if($level === 3){
      $difficulty ='
      <p style="color:'.$color[2]. '";>' . $label[2] . '</p>';
    }
    if($level === 4){
      $difficulty ='
      <p style="color:'.$color[3]. '";>' . $label[3] . '</p>';
    }
    if($level === 5){
      $difficulty ='
      <p style="color:'.$color[4]. '";>' . $label[4] . '</p>';
    }
    return $difficulty;
}

/**
 * Afficher pour l'utilisateur $idUser sa progression pour le challenge $idChallenge
 *
 *
 * @param $idUser l'id de l'utilisateur
 *@param $idChallenge l'id du challenge.
 */
function displayProgression($idUser , $idChallenge){
  if(is_array($data["challengesPlayed"])){
  foreach($data["challengesPlayed"] as $challengePlayed){

  if ($challengePlayed->ChallengePlayedByUser($idUser,$idChallenge)){
    $challengePlayed =$challengePlayed.fetch($idUser,$idChallenge);
    $progression =   '<p>' .$challengePlayed.getProgression()     . '</p>';
  }else{
    $progression = '<p>Jamais joué </p>';
  }
}
}else{
  $progression = '<p>Jamais joué </p>';
}
return $progression;
}
?>

<?php include_once 'layout/header.php' ?>

<header class="container text-center">
  <div class="jumbotron">
    <h1 class="display-1">Ma progression</h1>
    <p class="lead">Avec ce tableau de bord, tu peux suivre ta progression dans cette formidable aventure !</div>
  </div>
</header>

<section class="container mt-5">
  <table class="table table-striped table-hover">
    <tr>
      <th class="text-muted">#</th>
      <th>Nom</th>
      <th>Difficulté</th>
      <th>Progression</th>
    </tr>
    <?php foreach($data["challenges"] as $challenges): ?>
      <tr>
        <td class="text-muted">
          <?= $challenges->getId() ?>
        </td>
        <td>
          <a href="challenge.php?id=<?= $challenges->getId() ?>">
            <?= $challenges->getName() ?>
          </a>
        </td>
        <td>
          <?= displayDifficulty($challenges->getDifficultyLevel()) ?>
        </td>
        <td>
          <?= displayProgression($this->security->id, $challenges->getId()) ?>
        </td>
      </tr>
    <?php endforeach; ?>
  </table>
</section>

<?php include_once 'layout/footer.php' ?>
