<?php
include_once "../src/Utils/autoloader.php";
$scripts = "";

if (isset($_POST["password"])) {
    // Ceci est BIEN EVIDEMMENT temporaire, le mot de passe sera chiffré et stocké ailleurs
    // (et ne sera pas "admin")
    if ($_POST["password"] == "admin") {
        $_SESSION["Id"] = "defaut0000";

        include_once("login.php");
    } else {
        $scripts .= "alert('Mauvais mot de passe !');";
    }
}
 ?>

<!DOCTYPE html>
<html lang="fr" dir="ltr">

<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>VocasIItE | Admin</title>
  <link rel="stylesheet" href="/css/main.css">
  <link rel="stylesheet" href="/css/lib/bulma.css">
  <link rel="icon" type="image/png" href="/img/logo.png">
  <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
</head>

<body>
  <?php include_once '../src/View/navbar.php'; ?>

  <section class="hero">
    <div class="hero-body">
      <div class="container">
        <div class="columns is-centered">
          <div class="column is-5-tablet is-4-desktop is-3-widescreen">
            <form action="" method="post" class="box">
              <div class="field">
                <label for="" class="label">ADMIN - Mot de passe</label>
                <div class="control has-icons-left">
                  <input type="password" placeholder="*******" name="password" class="input" required>
                  <span class="icon is-small is-left">
                    <i class="fa fa-lock"></i>
                  </span>
                </div>
              </div>
              <div class="field">
                <button class="button is-success">
                  Connexion
                </button>
              </div>
            </form>
          </div>
        </div>
      </div>
    </div>
  </section>
  <script>
    <?php echo $scripts ?>
  </script>

</body>

</html>
