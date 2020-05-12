<?php
if (empty($_GET)) {
    echo "Erreur : action invalide";
    exit;
}

include_once "../src/Utils/autoloader.php";
$dbAdapter = (new dbFactory())->createService();

$droits = getDroits();

if ($droits == "visiteur") {
    header("Location: /denied.php");
}

$canSeePrivate = ($droits == "membre" || $droits == "admin");

$id = $_GET["id"] ?? 0;

$soiree = "";
$theme = "";
$date = "";
$songs = [];

if ($id != 0) {
    $sql = <<<SQL
  SELECT nom, theme, date_soiree, publique FROM soiree
  WHERE id = :id
  SQL;
    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':id', $id, PDO::PARAM_INT);
    $result->execute();

    if ($result->rowCount() == 0) {
        // If a party with ID $id does not exist, we reset $id to 0 (error)
        $id = 0;
    } else {
        $row = $result->fetch();
        $soiree = $row['nom'];
        $theme = $row['theme'];
        $date = $row['date_soiree'];
        $public = $row['publique'];

        // Si la soirée n'est pas publique et que l'utilisateur n'est pas membre ou plus
        if (!$public && !$canSeePrivate) {
            header("Location: /denied.php?lastpage=/soirees.php");
        }

        date_default_timezone_set('Europe/Paris');
        setlocale(LC_ALL, 'fr_FR.utf8');
        setlocale(LC_ALL, 'fr_FR');
        $date = strftime("%A %e %B %Y", strtotime($date));
    }

    //Récupère les chanson sous forme de chanson_soiree
    $sql = <<<SQL
  SELECT chanson.id as id, chanson.nom as nom, chanson.artiste as artiste, chanson_soiree.id as cs_id
  FROM chanson_soiree
  JOIN soiree ON id_soiree = soiree.id
  JOIN chanson ON id_chanson = chanson.id
  WHERE id_soiree = :id
  SQL;
    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $songs = $result->fetchAll();

    //Récupère les chanteurs
    foreach ($songs as $key => $song) {
        $sql = <<<SQL
      SELECT id_utilisateur FROM chanteur
      WHERE id_cs = :cs_id
      SQL;
        $result = $dbAdapter->prepare($sql);
        $result->bindValue(':cs_id', $song["cs_id"], PDO::PARAM_INT);
        $result->execute();

        $chanteurs = $result->fetchAll();

        if (isAuthenticated()) {
            $songs[$key]["singing"] = 0;
        }

        $disp = "Chantent : ";

        if ($result->rowCount() == 0) {
            $disp .= "personne, ";
        }

        foreach ($chanteurs as $chanteur) {
            $disp .= $chanteur["id_utilisateur"] . ", ";

            if (isAuthenticated() && $_SESSION["Id"] == $chanteur["id_utilisateur"]) {
                $songs[$key]["singing"] = 1;
            }
        }

        $songs[$key]["chanteurs"] = substr($disp, 0, -2);
    }
}
?>

<!DOCTYPE html>
<html lang="fr">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Visualisation d'une soirée</title>
  <link rel="icon" type="image/png" href="/img/logo.png">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/viewSoiree.css">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
  <script src="/js/lib/showdown.min.js"></script>
</head>

<body>
  <?php include_once '../src/View/navbar.php'; ?>
  <section class="section">
    <div class="container">
      <h3 id="title" class="title is-3">
        <?php
        if ($id == 0) {
            echo "Erreur : ID invalide";
        } else {
            echo "Visualisation d'une soirée";
        }
        ?>
      </h3>

      <div class="box has-text-centered">
        <?php if ($id != 0): ?>
          <h4 class="title is-4">Soirée <?php echo $soiree ?></h4>
          <h5 class="title is-5">
            <em>Thème&nbsp;&nbsp;–&nbsp;&nbsp;</em>
            <?php echo $theme ?>
            <br>
            <em>Date&nbsp;&nbsp;–&nbsp;&nbsp;</em>
            <?php echo $date ?>
          </h5>
        <?php else: ?>
          <h4 class="title is-4">Rien à voir ici, circulez.</h4>
        <?php endif; ?>
      </div>

      <?php if (count($songs) > 0):?>
        <div class="block songs">
          <input type="hidden" name="songs" value="">
          <label class="label">Chansons</label>
          <ul id="songList" class="list">
            <?php foreach ($songs as $song): ?>
              <li class="list-item">
                <div class="level is-mobile">
                  <div class="level-left">
                    <div class="level-item icon">
                      <i class="fas fa-music"></i>
                    </div>
                    <div class="level-item">
                      <div>
                        <em><?php echo $song["nom"]?> </em>
                        <p class="smaller"><?php echo $song["artiste"]?></p>
                      </div>
                    </div>
                  </div>
                  <div class="level-right block">
                    <span class="level-item has-text-dark" title="<?php echo $song["chanteurs"]; ?>">
                      <span class="icon">
                        <i class="fas fa-list"></i>
                      </span>
                    </span>
                    <a class="level-item has-text-dark" href="viewSong.php?id=<?php echo $song["id"]?>">
                      <span class="icon">
                        <i class="fas fa-eye"></i>
                      </span>
                    </a>
                    <?php if (isAuthenticated()): ?>

                      <?php if ($song["singing"]): ?>
                        <a title="Cliquez pour ne plus chanter cette chanson" class="level-item" href="singSong.php?cs_id=<?php echo $song["cs_id"]?>&soiree_id=<?php echo $id?>&action=2">
                          ✅
                        </a>
                      <?php else: ?>
                        <a title="Cliquez pour chanter cette chanson" class="level-item" href="singSong.php?cs_id=<?php echo $song["cs_id"]?>&soiree_id=<?php echo $id?>&action=1">
                          🎤
                        </a>
                      <?php endif; ?>

                    <?php endif; ?>
                  </div>
                </div>
              </li>
            <?php endforeach; ?>
          </ul>
        </div>

      <?php elseif ($id != 0): ?>
        <article class="message is-warning">
          <div class="message-body">
            Aucune chanson n'a été ajoutée à cette soirée
          </div>
        </article>

      <?php endif; ?>
    </div>
  </section>
</body>

</html>
