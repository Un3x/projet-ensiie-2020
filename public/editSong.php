<?php
  include_once '../src/Utils/autoloader.php';
  $dbAdapter = (new dbFactory())->createService();

  $droits = getDroits();

  if ($droits == "visiteur" || $droits == "iien") {
      header("Location: /denied.php?lastpage=/songs.php");
  }

  $scripts = "";

  //Convention : $action = 1 : create, $action = 2 : update

  //POST (data from the form the below in this same page)
  if (!empty($_POST)) {
      $rAction = $_POST["action"] ?? 0;
      $rId = $_POST["id"] ?? 0;
      if (empty($_POST["artist"])) {
          $_POST["artist"] = "Inconnu";
      }

      if ($rAction == 0) {
          //Invalid POST action
          echo "Erreur : action invalide";
          exit;
      } elseif ($rAction == 1 && !empty($_POST["title"])) {
          //Inserting song in the DB if title not null
          $sql = <<<SQL
      INSERT INTO chanson (nom, artiste, paroles, id_utilisateur)
      VALUES (:title, :artist, :lyrics, :user)
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
          $result->bindValue(':artist', $_POST["artist"], PDO::PARAM_STR);
          $result->bindValue(':lyrics', $_POST["lyrics"], PDO::PARAM_STR);
          if (isset($_SESSION) && !empty($_SESSION["Id"])) {
              $result->bindValue(':user', $_SESSION["Id"], PDO::PARAM_STR);
          } else {
              $result->bindValue(':user', "defaut0000", PDO::PARAM_STR);
          }
          $result->execute();

          // To get the ID just added
          $result = $dbAdapter->prepare("SELECT id FROM chanson ORDER BY id DESC LIMIT 1");
          $result->execute();
          $rId = $result->fetch()["id"];
      } elseif ($rAction == 2 && !empty($_POST["title"])) {
          // Getting the user id from the song to see if he's allowed to edit it
          $sql = "SELECT id_utilisateur AS idu FROM chanson WHERE id = :id";
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':id', $rId, PDO::PARAM_INT);
          $result->execute();
          if ($droits != "admin" && $_SESSION["Id"] != $result->fetch()["idu"]) {
              //Etonnament, un header ne marchait pas. Mais bon, ce cas est très rare de toutes façons.
              include_once "denied.php";
              exit();
          }

          // Updating the song
          $sql = <<<SQL
      UPDATE chanson
      SET nom = :title, artiste = :artist, paroles = :lyrics
      WHERE id = :id
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':id', $rId, PDO::PARAM_INT);
          $result->bindValue(':title', $_POST["title"], PDO::PARAM_STR);
          $result->bindValue(':artist', $_POST["artist"], PDO::PARAM_STR);
          $result->bindValue(':lyrics', $_POST["lyrics"], PDO::PARAM_STR);
          $result->execute();

          //On supprime les liens pour les rajouter après :)
          $result = $dbAdapter->prepare("DELETE FROM lien WHERE id_chanson = :id");
          $result->bindValue(':id', $rId, PDO::PARAM_INT);
          $result->execute();
      }

      // Finalement, ajout ou update, on s'occupe des liens
      $links = explode("<br />", nl2br($_POST["links"]));

      foreach ($links as $link) {
          if (!empty($link)) {
              $linkParts = explode(",", $link);
              if (count($linkParts) == 2) {
                  $sql = <<<SQL
          INSERT INTO lien (type_lien, lien, id_chanson)
          VALUES (:type, :link, :id)
SQL;
                  $result = $dbAdapter->prepare($sql);
                  $result->bindValue(':type', trim($linkParts[0]), PDO::PARAM_STR);
                  $result->bindValue(':link', trim($linkParts[1]), PDO::PARAM_STR);
                  $result->bindValue(':id', $rId, PDO::PARAM_INT);
                  $result->execute();
              }
          }
      }

      header("Location: /editSong.php?action=2&id=" . $rId . "&past=" . $rAction);
  }

  //GET
  $action = $_GET["action"] ?? 0;
  $id = $_GET["id"] ?? 0;
  $past = $_GET["past"] ?? 0; // Action qui vient d'être effectuée pour alert()

  // Initialize values of input fields
  $song = "";
  $artist = "";
  $lyrics = "";
  $nomComplet = "";
  $links = "";

  if ($action == 2 && $id != 0) {
      // Informations sur la chanson
      $sql = <<<SQL
    SELECT chanson.nom AS c_nom, artiste, paroles, pseudo, prenom, utilisateur.nom AS u_nom, id_utilisateur AS u_id
    FROM chanson
    JOIN utilisateur ON id_utilisateur = utilisateur.id
    WHERE chanson.id = :id
SQL;
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();

      if ($result->rowCount() == 0) {
          // If a song with ID $id does not exist, we reset $id to 0 (error)
          $id = 0;
      } else {
          $row = $result->fetch();
          $song = $row['c_nom'];
          $artist = $row['artiste'];
          $lyrics = $row['paroles'];
          $u_prenom = $row['prenom'];
          $u_pseudo = $row['pseudo'];
          $u_nom = $row['u_nom'];
          $nomComplet .= ($u_prenom . ' &quot;' . $u_pseudo . '&quot; ' . $u_nom);

          //Si l'utilisateur n'a pas le droit de modifier la chanson
          if ($droits != "admin" && $_SESSION["Id"] != $row['u_id']) {
              header("Location: /denied.php?lastpage=/songs.php");
          }

          // Si on vient d'une page de modif / ajout
          if ($past == 1) {
              $scripts .= "alert(`La chanson '" . $song . "' a bien été créée !`);";
          } elseif ($past == 2) {
              $scripts .= "alert(`La chanson '" . $song . "' a bien été modifiée !`);";
          }

          // Liens de la chanson
          $sql = <<<SQL
      SELECT lien, type_lien
      FROM lien WHERE id_chanson = :id
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':id', $id, PDO::PARAM_INT);
          $result->execute();
          foreach ($result->fetchAll() as $link) {
              $links .= $link["type_lien"] . ", " . $link["lien"] . "\n";
          }
      }
  }
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>
    <?php
      if ($action == 0 || ($action == 2 && $id == 0)) {
          echo "Erreur";
      } elseif ($action == 1) {
          echo "Ajout d'une chanson";
      } elseif ($action == 2) {
          echo "Modification d'une chanson";
      }
    ?>
  </title>
  <link rel="icon" type="image/png" href="/img/logo.png">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/editSong.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="/js/lib/showdown.min.js"></script>
</head>

<body>
  <?php include_once '../src/View/navbar.php'; ?>

  <section class="section">
    <div class="container">
      <h3 class="title is-3" id="title">
        <?php
          if ($action == 0) {
              echo "Erreur : action inconnue";
          } elseif ($action == 2 && $id == 0) {
              echo "Erreur : ID inconnue";
          } elseif ($action == 1) {
              echo "Ajout d'une chanson";
          } elseif ($action == 2) {
              echo "Modification de la chanson : <em>" . $song . "</em>";
          }
        ?>
      </h3>

      <form id="form" method="post" class="form">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">

        <div class="columns">
          <div class="field column">
            <label class="label">Titre</label>
            <div class="control has-icons-left">
              <input class="input" type="text" placeholder="Titre" name="title" value="<?php echo $song; ?>">
              <span class="icon is-small is-left">
                <i class="fas fa-pen"></i>
              </span>
            </div>
          </div>

          <div class="field column">
            <label class="label">Artiste</label>
            <div class="control has-icons-left">
              <input type="text" placeholder="Inconnu" name="artist" value="<?php echo $artist; ?>" class="input">
              <span class="icon is-small is-left">
                <i class="fas fa-music"></i>
              </span>
            </div>
          </div>

          <div class="field column">
            <label class="label">Utilisateur</label>
            <div class="control has-icons-left">
              <input type="text" placeholder="Toi" name="user" value="<?php echo $nomComplet; ?>" class="input" disabled>
              <span class="icon is-small is-left">
                <i class="fas fa-user"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="columns">
          <div class="column is-half left">
            <div class="field lyrics">
              <textarea name="lyrics" class="textarea" aria-label="Paroles" placeholder="Paroles"><?php echo $lyrics; ?></textarea>
            </div>

            <div class="field links">
              <label class="label">Liens</label>
              <textarea name="links" class="textarea"><?php echo $links; ?></textarea>
            </div>
          </div>

          <div id="disp" class="message content column is-half"></div>

        </div>
        <button type="submit" class="button is-fullwidth is-info">Valider</button>
      </form>
    </div>
  </section>

  <script>
    let form = document.getElementById("form");
    let disp = document.getElementById("disp");
    let sdConverter = new showdown.Converter();

    function updateText(e) {
      let toConvert = "";
      let titre = form.title.value || form.title.placeholder;
      let artiste = form.artist.value || form.artist.placeholder;
      let paroles = form.lyrics.value.replace(/\n/g, "  \n") || form.lyrics.placeholder;
      toConvert += "#" + titre + "  \n";
      toConvert += "### *" + artiste + "*  \n";
      toConvert += paroles;
      disp.innerHTML = sdConverter.makeHtml(toConvert);
    }
    form.addEventListener("input", updateText);

    form.addEventListener("submit", e => {
      updateText(e);
    });

    updateText();
  </script>
  <script><?php echo $scripts ?></script>
</body>

</html>
