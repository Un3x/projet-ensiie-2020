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
  <title>VocasIItE | Soirées</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/soirees.css">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="icon" type="image/png" href="/img/logo.png">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
  <?php include_once '../src/View/navbar.php'; ?>
  <section class="section">
    <div class="container">
      <h3 id="title" class="title is-3">Soirées - création, recherche</h3>

      <?php if ($droits == "admin"): ?>
      <div class="block">
        <button class="button is-info" onclick="window.location = 'editSoiree.php?action=1';">
          <span class="icon">
            <i class="fas fa-plus"></i>
          </span>
          <span>Ajoutez une soirée</span>
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
              echo "Ou bien cherchez par année";
          } else {
              echo "Cherchez par année";
          }
          ?></span>
        </span>
      </h4>

      <form id="form" class="form columns">
        <div class="field column">
          <div class="select">
            <select name="year">
              <option>Sélectionnez une année</option>
            </select>
          </div>
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

    let now = new Date();
    let yLimit = now.getMonth() < 8 ? now.getFullYear() - 1 : now.getFullYear();
    for (let y = yLimit; y > 2017; y--) {
      form.year.innerHTML += `<option>${y + "-" + (y + 1)}</option>`;
    }

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
          if (confirm("Voulez-vous vraiment supprimer cette soirée ?"))
            deleteSoiree(btn.attributes.partyid.value);
        });
      }
    }

    function deleteSoiree(id) {
      let uri = `deleteSoiree.php?id=${id}`;
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
            let dateSoiree = new Date(result.date_soiree);
            let dateOptions = {weekday: "long", month: "long", day: "numeric"};
            let dateDisp = dateSoiree.toLocaleDateString("fr-FR", dateOptions);

            disp.innerHTML += `<li class="list-item">
            <div class="level is-mobile">
              <div class="level-left">
                <div class="level-item icon">
                  <i class="fas fa-calendar"></i>
                </div>
                <div class="level-item">
                  <div>
                    ${result.nom}
                    <em class="smallerButNotTooMuch"> (${result.theme})</em>
                    <p class="smaller">${dateDisp}</p>
                  </div>
                </div>
              </div>
              <div class="level-right block">
                <a class="level-item has-text-dark" href="viewSoiree.php?id=${result.id}">
                  <span class="icon">
                    <i class="fas fa-eye"></i>
                  </span>
                </a>
                <?php if (getDroits() == "admin"): ?>
                <a class="level-item has-text-dark" href="editSoiree.php?action=2&id=${result.id}">
                  <span class="icon">
                    <i class="fas fa-pen"></i>
                  </span>
                </a>
                <a class="level-item has-text-danger supprimer" partyid="${result.id}">
                  <span class="icon">
                    <i class="fas fa-trash"></i>
                  </span>
                </a>
                <?php endif; ?>
              </div>
            </div>
          </li>`;
          }
          updateDeleteButtons();
        } else {
          info("Rien n'a été trouvé pour cette année");
        }
      }
    };

    function searchRequest() {
      let year = form.year.value.split("-");
      if (year.length == 1) {
        info("Veuillez renseigner le formulaire");
      } else {
        let uri = `searchSoirees.php?year1=${year[0]}&year2=${year[1]}`;
        searchXhttp.open("GET", encodeURI(uri), true);
        searchXhttp.send();
      }
    }

    function fetchSoirees() {
      if (canRequest) {
        canRequest = false;
        searchRequest();

        setTimeout(() => {
          canRequest = true;
          searchRequest();
        }, 1000);
      }
    }

    form.addEventListener("input", fetchSoirees);
    searchRequest();
  </script>
</body>

</html>
