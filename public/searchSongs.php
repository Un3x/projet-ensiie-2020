<?php
  if (empty($_GET)) {
      exit;
  }

  include_once "../src/Utils/autoloader.php";
  $dbAdapter = (new dbFactory())->createService();

  $title = $_GET["title"] ?? "";
  $artist = $_GET["artist"] ?? "";

  $sql = <<<SQL
    SELECT nom, artiste, id, id_utilisateur FROM chanson
    WHERE UPPER(nom) LIKE UPPER(:title) AND UPPER(artiste) LIKE UPPER(:artist)
SQL;
  $result = $dbAdapter->prepare($sql);
  $result->bindValue(':title', '%'.$title.'%', PDO::PARAM_STR);
  $result->bindValue(':artist', '%'.$artist.'%', PDO::PARAM_STR);
  $result->execute();

  $echo = "";

  $echo .= "[";
  foreach ($result->fetchAll() as $result) {
      $echo .= "{";
      //On informe l'utilisateur si il a le droit ou non de modifier
      if ((isAuthenticated() && $_SESSION["Id"] == $result["id_utilisateur"]) || getDroits() == "admin") {
          $echo .= '"authorized":true,';
      } else {
          $echo .= '"authorized":false,';
      }
      foreach ($result as $key => $value) {
          if (!is_numeric($key)) {
              $echo .= '"'.$key.'":"'.$value.'",';
          }
      }
      $echo .= "},";
  }
  $echo .= "]";

  $echo = str_replace(",}", "}", $echo);
  echo str_replace(",]", "]", $echo);
