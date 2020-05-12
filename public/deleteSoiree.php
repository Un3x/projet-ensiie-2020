<?php
  if (empty($_GET)) {
      exit;
  }

  include_once "../src/Utils/autoloader.php";
  $dbAdapter = (new dbFactory())->createService();

  $id = $_GET["id"] ?? 0;

  if ($id != 0 && getDroits() == "admin") {
      // Trois requêtes à la suite (j'ai essayé de faire les trois en une, ça ne marchait pas)
      $sql = "DELETE FROM chanteur USING chanteur JOIN chanson_soiree ON chanson_soiree.id = id_cs WHERE id_soiree = :id";
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();

      $sql = "DELETE FROM chanson_soiree WHERE id_soiree = :id";
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();

      $sql = "DELETE FROM soiree WHERE id = :id";
      $result = $dbAdapter->prepare($sql);
      $result->bindValue(':id', $id, PDO::PARAM_INT);
      $result->execute();
  }
