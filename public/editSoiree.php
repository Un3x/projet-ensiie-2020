<?php
  include_once '../src/Utils/autoloader.php';
  $dbAdapter = (new dbFactory())->createService();
  $scripts = "";

  if (getDroits() != "admin") {
      header("Location: /denied.php?lastpage=/soirees.php");
  }

  //Convention : $action = 1 : create, $action = 2 : update

  // POST (data from the form the below in this same page)
  if (!empty($_POST)) {
      $rAction = $_POST["action"] ?? 0;
      $rId = $_POST["id"] ?? 0;
      if (empty($_POST["name"])) {
          $_POST["name"] = "Inconnu";
      }
      if (empty($_POST["theme"])) {
          $_POST["theme"] = "Inconnu";
      }
      if (empty($_POST["public"])) {
          $_POST["public"] = 0;
      } else {
          $_POST["public"] = (int) $_POST["public"];
      }

      if ($rAction == 0) {
          //Invalid POST action
          echo "Erreur : action invalide";
          exit;
      } elseif ($rAction == 1 && !empty($_POST["date"])) {
          //Inserting party in the DB if date not null
          $sql = <<<SQL
      INSERT INTO soiree (nom, theme, date_soiree, publique)
      VALUES (:name, :theme, :partyDate, :public)
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
          $result->bindValue(':theme', $_POST["theme"], PDO::PARAM_STR);
          $result->bindValue(':partyDate', $_POST["date"], PDO::PARAM_STR);
          $result->bindValue(':public', $_POST["public"], PDO::PARAM_BOOL);
          $result->execute();

          // To get the ID just added
          $result = $dbAdapter->prepare("SELECT id FROM soiree ORDER BY id DESC LIMIT 1");
          $result->execute();
          $rId = $result->fetch()["id"];
      } elseif ($rAction == 2 && !empty($_POST["date"])) {
          // Updating the song
          $sql = <<<SQL
      UPDATE soiree
      SET nom = :name, theme = :theme, date_soiree = :partyDate, publique = :public
      WHERE id = :id
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':id', $rId, PDO::PARAM_INT);
          $result->bindValue(':name', $_POST["name"], PDO::PARAM_STR);
          $result->bindValue(':theme', $_POST["theme"], PDO::PARAM_STR);
          $result->bindValue(':partyDate', $_POST["date"], PDO::PARAM_STR);
          $result->bindValue(':public', $_POST["public"], PDO::PARAM_BOOL);
          $result->execute();

          //On supprime les chansons pour les rajouter après :)
          $result = $dbAdapter->prepare("DELETE FROM chanson_soiree WHERE id_soiree = :id");
          $result->bindValue(':id', $rId, PDO::PARAM_INT);
          $result->execute();
      }

      // Finalement, ajout ou update, on s'occupe des chansons
      $songs = explode(",", $_POST["songs"]);

      foreach ($songs as $song) {
          $sql = <<<SQL
      INSERT INTO chanson_soiree (id_chanson, id_soiree)
      VALUES (:idc, :ids)
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':idc', (int) $song, PDO::PARAM_INT);
          $result->bindValue(':ids', $rId, PDO::PARAM_INT);
          $result->execute();
      }

      header("Location: /editSoiree.php?action=2&id=" . $rId . "&past=" . $rAction);
  }

  // GET
  $action = $_GET["action"] ?? 0;
  $id = $_GET["id"] ?? 0;
  $past = $_GET["past"] ?? 0; // Action qui vient d'être effectuée pour alert()

  $name = "";
  $theme = "";
  $date = "";
  $chansons = [];
  $public = 0;

  if ($action == 2 && $id != 0) {
      // Informations sur la soirée
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
          $name = $row['nom'];
          $theme = $row['theme'];
          $date = $row['date_soiree'];
          $public = $row['publique'];

          // Si on vient d'une page de modif / ajout
          if ($past == 1) {
              $scripts .= "alert(`La soirée '" . $name . "' a bien été créée !`);";
          } elseif ($past == 2) {
              $scripts .= "alert(`La soirée '" . $name . "' a bien été modifiée !`);";
          }

          // Chansons de la soirée
          $sql = <<<SQL
      SELECT chanson.id, chanson.nom, artiste
      FROM chanson_soiree
      JOIN chanson ON id_chanson = chanson.id
      JOIN soiree ON id_soiree = soiree.id
      WHERE id_soiree = :id
SQL;
          $result = $dbAdapter->prepare($sql);
          $result->bindValue(':id', $id, PDO::PARAM_INT);
          $result->execute();
          $chansons = $result->fetchAll();
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
          echo "Ajout d'une soirée";
      } elseif ($action == 2) {
          echo "Modification d'une soirée";
      }
    ?>
  </title>
  <link rel="icon" type="image/png" href="/img/logo.png">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/editSoiree.css">
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
              echo "Ajout d'une soirée";
          } elseif ($action == 2) {
              echo "Modification de la soirée : <em>" . $name . "</em>";
          }
        ?>
      </h3>

      <form id="form" method="post" class="form">
        <input type="hidden" name="action" value="<?php echo $action ?>">
        <input type="hidden" name="id" value="<?php echo $id ?>">

        <div class="columns">
          <div class="field column">
            <label class="label">Nom</label>
            <div class="control has-icons-left">
              <input class="input" type="text" placeholder="Inconnu" name="name" value="<?php echo $name; ?>">
              <span class="icon is-small is-left">
                <i class="fas fa-tag"></i>
              </span>
            </div>
          </div>

          <div class="field column">
            <label class="label">Thème</label>
            <div class="control has-icons-left">
              <input type="text" placeholder="Inconnu" name="theme" value="<?php echo $theme; ?>" class="input">
              <span class="icon is-small is-left">
                <i class="fas fa-image"></i>
              </span>
            </div>
          </div>

          <div class="field column">
            <label class="label">Date</label>
            <div class="control has-icons-left">
              <input type="date" placeholder="Jamais" name="date" value="<?php echo $date; ?>" class="input">
              <span class="icon is-small is-left">
                <i class="fas fa-calendar"></i>
              </span>
            </div>
          </div>
        </div>

        <div class="field has-text-centered">
          <input id="publicInput" type="hidden" name="public" value="<?php echo $public ?>">
          <button id="publicBtn" type="button" class="button <?php if ($public) {
            echo"is-success";
        } else {
            echo "is-info";
        } ?> is-light" onclick="switchPublic();">
            <span class="icon">
              <i class="fas <?php if ($public) {
            echo"fa-check";
        } else {
            echo "fa-times";
        } ?>" id="publicIcon"></i>
            </span>
            <span id="publicText"><?php if ($public) {
            echo"Publique";
        } else {
            echo "Non publique";
        } ?></span>
          </button>
          <script>
          function switchPublic() {
            let publicBtn = document.getElementById("publicBtn");
            let publicInput = document.getElementById("publicInput");
            let publicIcon = document.getElementById("publicIcon");
            let publicText = document.getElementById("publicText");

            if (publicInput.value == "1") {
              publicIcon.attributes["data-icon"].value = "times";
              publicBtn.classList.remove("is-success");
              publicBtn.classList.add("is-info");
              publicText.innerText = "Non publique";
            } else {
              publicIcon.attributes["data-icon"].value = "check";
              publicBtn.classList.remove("is-info");
              publicBtn.classList.add("is-success");
              publicText.innerText = "Publique";
            }

            publicInput.value = (1 - Number(publicInput.value)).toString();
          }
          </script>
        </div>

        <div class="block songs">
          <input type="hidden" name="songs" value="">
          <label class="label">Chansons</label>

          <ul id="songList" class="list">
          </ul>
          <article id="emptyInfo" class="message is-warning">
            <div class="message-body">
              Aucune chanson n'a été ajoutée à cette soirée
            </div>
          </article>
        </div>

        <div id="search" class="block">
          <h6 class="title is-6 level">
            <span class="level-left">
              <span class="icon level-item">
                <i class="fas fa-arrow-down"></i>
              </span>
              <span class="level-item">Recherche de chansons</span>
            </span>
          </h6>

          <div id="searchForm" class="columns">
            <div class="field column">
              <label>Titre</label>
              <input id="searchTitle" class="input" type="text" value="">
            </div>

            <div class="field column">
              <label>Artiste</label>
              <input id="searchArtist" class="input" type="text" value="">
            </div>
          </div>

          <ul id="disp" class="list">
          </ul>
        </div>

        <button type="submit" class="button is-fullwidth is-info">Valider</button>
      </form>
    </div>
  </section>
  <script>
    let form = document.getElementById("form");
    let songList = document.getElementById("songList");
    let emptyInfo = document.getElementById("emptyInfo");
    let disp = document.getElementById("disp");
    let searchForm = document.getElementById("searchForm");
    let titleInput = document.getElementById("searchTitle");
    let artistInput = document.getElementById("searchArtist");
    let canRequest = true;
    let searchXhttp = new XMLHttpRequest();
    let songs = [];

    function updateSongsDisp() {
      if (songs.length > 0) {
        songList.style.display = "";
        emptyInfo.style.display = "none";
      } else {
        songList.style.display = "none";
        emptyInfo.style.display = "";
      }
    }

    function addSong(id, title, artist) {
      if (songs.indexOf(id) == -1) {
        songs.push(id);
        form.songs.value = songs.toString();

        songList.innerHTML += `<li id="song${id}" class="list-item">
          <div class="level is-mobile">
            <div class="level-left">
              <div class="level-item">
                <div>
                  <em>${title}</em>
                  <p class="smaller">${artist}</p>
                </div>
              </div>
            </div>
            <div class="level-right block">
              <a class="level-item has-text-dark" onclick="removeSong('${id}');">
                <span class="icon">
                  <i class="fas fa-minus"></i>
                </span>
              </a>
            </div>
          </div>
        </li>`;
      }

      updateSongsDisp();
    }

    function removeSong(id) {
      let index = songs.indexOf(id);
      if (index != -1) {
        songs.splice(index, 1);
        form.songs.value = songs.toString();
        let toRemove = document.getElementById("song" + id);
        songList.removeChild(toRemove);
      }
      updateSongsDisp();
    }

    searchXhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        let json = JSON.parse(this.responseText);

        if (json.length > 0) {
          disp.innerHTML = "";
          disp.style.display = "";

          for (let result of json) {
            let li = document.createElement("li");
            li.classList.add("list-item");
            li.innerHTML = `<div class="level is-mobile">
              <div class="level-left">
                <div class="level-item">
                  <div>
                    <em>${result.nom}</em>
                    <p class="smaller">${result.artiste}</p>
                  </div>
                </div>
              </div>
              <div class="level-right block">
                <a class="level-item has-text-dark plus">
                  <span class="icon">
                    <i class="fas fa-plus"></i>
                  </span>
                </a>
              </div>
            </div>`;

            li.getElementsByClassName("plus")[0].addEventListener("click", ()=>{
              addSong(result.id, result.nom, result.artiste);
            });
            disp.appendChild(li);
          }
        } else {
          disp.innerHTML = "";
          disp.style.display = "none";
        }
      }
    };

    function searchRequest() {
      let title = titleInput.value.trim().replace(/%/g, "percent"),
      artist = artistInput.value.trim().replace(/%/g, "percent");
      if (title == "" && artist == "") {
        disp.innerHTML = "";
        disp.style.display = "none";
      } else {
        let uri = `searchSongs.php?title=${title}&artist=${artist}`;
        searchXhttp.open("GET", encodeURI(uri), true);
        searchXhttp.send();
      }
    }

    function fetchSongs() {
      if (canRequest) {
        canRequest = false;
        searchRequest();

        setTimeout(() => {
          canRequest = true;
          searchRequest();
        }, 1000);
      }
    }

    let toProcess = <?php echo json_encode($chansons); ?>;
    for (let song of toProcess) {
      addSong(song.id.toString(), song.nom, song.artiste);
    }

    searchForm.addEventListener("input", fetchSongs);
    searchRequest();
    updateSongsDisp();
  </script>
  <script><?php echo $scripts ?></script>
</body>

</html>
