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

$id = $_GET["id"] ?? 0;

$song = "";
$artist = "";
$lyrics = "";
$links = [];

if ($id != 0) {
    $sql = <<<SQL
  SELECT nom, artiste, paroles FROM chanson
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
        $song = $row['nom'];
        $artist = $row['artiste'];
        $lyrics = $row['paroles'];
    }

    $sql = <<<SQL
  SELECT lien, type_lien
  FROM lien WHERE id_chanson = :id
  SQL;
    $result = $dbAdapter->prepare($sql);
    $result->bindValue(':id', $id, PDO::PARAM_INT);
    $result->execute();

    $links = $result->fetchAll();
}
?>
<!DOCTYPE html>
<html lang="fr" dir="ltr">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Visualisation d'une chanson</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/viewSong.css">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="icon" type="image/png" href="/img/logo.png">
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
            echo "Visualisation d'une chanson";
        }
        ?>
      </h3>
      <div class="block has-text-centered">
        <button id="zoom" class="button is-info is-light">
          <span class="icon">
            <i id="zoomIcon" class="fas fa-search-plus"></i>
          </span>
        </button>
        <?php foreach ($links as $link): ?>
          <a href="<?php echo $link["lien"]; ?>" class="button is-link is-light" target="_blank">
            <div class="level">
              <span class="icon levl-left">
                <i class="fas fa-link"></i>
              </span>
              <span class="level-right">
                <?php echo $link["type_lien"]; ?>
              </span>
            </div>
          </a>
        <?php endforeach; ?>
      </div>
      <div id="content" class="content has-text-centered is-size-5">
      </div>
    </div>
  </section>
  <script>
  let content = document.getElementById("content");
  let zoom = document.getElementById("zoom");
  let sdConverter = new showdown.Converter();
  let zoomState = false;

  let toConvert = "";
  let titre = "<?php echo $song ?>";
  let artiste = "<?php echo $artist ?>";
  let paroles = `<?php echo $lyrics ?>`.replace(/\n/g, "  \n");
  toConvert += "#" + titre + "  \n";
  toConvert += "### *" + artiste + "*  \n";
  toConvert += paroles;
  content.innerHTML = sdConverter.makeHtml(toConvert);

  zoom.addEventListener("click", ()=>{
    let zoomIcon = document.getElementById("zoomIcon");
    if (zoomState) {
      content.classList.remove("is-size-1");
      content.classList.add("is-size-5");
      zoom.classList.remove("is-success");
      zoom.classList.add("is-info");
      zoomIcon.attributes["data-icon"].value = "search-plus";
      zoomState = false;
    } else {
      content.classList.remove("is-size-5");
      content.classList.add("is-size-1");
      zoom.classList.remove("is-info");
      zoom.classList.add("is-success");
      zoomIcon.attributes["data-icon"].value = "search-minus";
      zoomState = true;
    }
  });
  </script>
</body>
</html>
