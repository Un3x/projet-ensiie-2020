<?php
  include_once "../src/Utils/autoloader.php";
  $droits = getDroits();

  if ($droits == "visiteur") {
      header("Location: /denied.php");
  }
?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VocasIItE | Chansons</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/songs.css">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="icon" type="image/png" href="/img/logo.png">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
  <?php include_once '../src/View/navbar.php'; ?>
  <section class="section">
    <div class="container">
      <h3 id="title" class="title is-3">Chansons - création, recherche</h3>

      <?php if ($droits == "admin" || $droits == "membre"): ?>
      <div class="block">
        <button class="button is-info" onclick="window.location = 'editSong.php?action=1';">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Ajoutez une chanson</span>
        </button>
      </div>
      <?php endif; ?>

      <h4 class="title is-4 level">
        <span class="level-left">
          <span class="icon level-item">
            <i class="fas fa-arrow-down"></i>
          </span>
          <span class="level-item"><?php
          if ($droits == "admin") {
              echo "Ou bien cherchez";
          } else {
              echo "Cherchez ici";
          }
          ?></span>
        </span>
      </h4>

      <form id="form" class="form columns">
        <div class="field column">
          <label>Titre</label>
          <input class="input" type="text" name="title" value="">
        </div>

        <div class="field column">
          <label>Artiste</label>
          <input class="input" type="text" name="artist" value="">
        </div>
      </form>

      <div id="info" class="box has-text-info has-background-light">
        <div class="level">
          <p id="info-text" class="level-left"></p>
          <span id="info-arrow" class="icon level-right">
            <i class="fas fa-arrow-down"></i>
          </span>
        </div>
      </div>

      <ul id="disp" class="list">
      </ul>

    </div>
  </section>
  <script>
    let disp = document.getElementById("disp");
    let form = document.getElementById("form");
    let infoBox = document.getElementById("info");
    let infoText = document.getElementById("info-text");
    let infoArrow = document.getElementById("info-arrow");

    let canRequest = true;
    let searchXhttp = new XMLHttpRequest();
    let deleteXhttp = new XMLHttpRequest();

    function info(text) {
      disp.innerHTML = "";
      disp.style.display = "none";
      infoArrow.style.display = "none";
      infoBox.classList.remove("has-text-success");
      infoBox.classList.add("has-text-info");
      infoText.innerText = text;
    }

    function success() {
      disp.innerHTML = "";
      disp.style.display = "";
      infoArrow.style.display = "";
      infoBox.classList.remove("has-text-info");
      infoBox.classList.add("has-text-success");
      infoText.innerText = `Résultats`;
    }

    function updateDeleteButtons() {
      for (let btn of document.getElementsByClassName("supprimer")) {
        btn.addEventListener("click", () => {
          if (confirm("Voulez-vous vraiment supprimer cette chanson ?"))
            deleteSong(btn.attributes.songid.value);
        });
      }
    }

    function deleteSong(id) {
      console.log("Deleting " + id);
      let uri = `deleteSong.php?id=${id}`;
      deleteXhttp.open("GET", encodeURI(uri), true);
      deleteXhttp.send();
      searchRequest();
    }

    searchXhttp.onreadystatechange = function() {
      if (this.readyState == 4 && this.status == 200) {
        let json = JSON.parse(this.responseText);

        if (json.length > 0) {
          success();

          for (let result of json) {
            let preparedHTML = "";
            preparedHTML += `<li class="list-item">
            <div class="level is-mobile">
              <div class="level-left">
                <div class="level-item icon">
                  <i class="fas fa-music"></i>
                </div>
                <div class="level-item">
                  <div>
                    <em>${result.nom}</em>
                    <p class="smaller">${result.artiste}</p>
                  </div>
                </div>
              </div>
              <div class="level-right block">
                <a class="level-item has-text-dark" href="viewSong.php?id=${result.id}">
                  <span class="icon">
                    <i class="fas fa-eye"></i>
                  </span>
                </a>`;
                if (result.authorized) {
                    preparedHTML += `
                    <a class="level-item has-text-dark" href="editSong.php?action=2&id=${result.id}">
                      <span class="icon">
                        <i class="fas fa-pen"></i>
                      </span>
                    </a>`;
                }
                preparedHTML += `
                <?php if (getDroits() == "admin"): ?>
                <a class="level-item has-text-danger supprimer" songid="${result.id}">
                  <span class="icon">
                    <i class="fas fa-trash"></i>
                  </span>
                </a>
                <?php endif; ?>
              </div>
            </div>
          </li>`;

          disp.innerHTML += preparedHTML;
          }
          updateDeleteButtons();
        } else {
          info("Rien n'a été trouvé");
        }
      }
    };

    function searchRequest() {
      let title = form.title.value.trim().replace(/%/g, "percent"),
        artist = form.artist.value.trim().replace(/%/g, "percent");
      if (title == "" && artist == "") {
        info("Veuillez renseigner le formulaire");
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

    form.addEventListener("input", fetchSongs);
    searchRequest();
  </script>
</body>

</html>
