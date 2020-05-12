<?php
  if (empty($_GET)) {
      exit;
  }

  include_once "../src/Utils/autoloader.php";
  $dbAdapter = (new dbFactory())->createService();

  $year1 = $_GET["year1"] ?? "";
  $year2 = $_GET["year2"] ?? "";

  $droits = getDroits();
  $canSeePrivate = ($droits == "membre" || $droits == "admin");

  $sql = <<<SQL
    SELECT nom, theme, date_soiree, publique, id FROM soiree
    WHERE date_soiree BETWEEN ? AND ?
    ORDER BY date_soiree DESC
SQL;
  $result = $dbAdapter->prepare($sql);
  $result->bindValue(1, $year1.'-08-01', PDO::PARAM_STR);
  $result->bindValue(2, $year2.'-07-31', PDO::PARAM_STR);
  $result->execute();

  $echo = "";

  $echo .= "[";
  foreach ($result->fetchAll() as $result) {
      if ($result["publique"] || $canSeePrivate) {
          $echo .= "{";
          foreach ($result as $key => $value) {
              /*result contient chaque résultat de  la requête sous la forme
              attribut => valeur, numero_attribut => valeur; Pour ne pas avoir
              la valeur en doublon on ne regarde pas les "numero_attribut"
              */
              if (!is_numeric($key)) {
                  $echo .= '"'.$key.'":"'.$value.'",';
              }
          }
          $echo .= "},";
      }
  }
  $echo .= "]";

  $echo = str_replace(",}", "}", $echo);
  echo str_replace(",]", "]", $echo);
