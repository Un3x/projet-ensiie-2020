<?php
  if (empty($_GET)) {
      exit;
  }

  include_once("../src/Utils/autoloader.php");
  $dbAdapter = (new dbFactory())->createService();

  $id = $_GET["id"] ?? 0;

  if ($id != 0 && getDroits() == "admin") {
      // Deux requêtes à la suite (j'ai essayé de faire les deux en une, ça ne marchait pas)
      $sql = "DELETE FROM lien WHERE id_chanson = :id";
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();

      $sql = "DELETE FROM chanson WHERE id = :id";
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();
  }
