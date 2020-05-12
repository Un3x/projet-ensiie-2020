<!DOCTYPE html>
<html lang="fr">
  
  <!-- HEAD -->
  <head>
    
    <!-- DESCRIPTION -->
    <meta charset="utf-8">
    <title>OTOMATE</title>
    <meta name="description" content="Corsaire hystérique">
    <meta name="author" content="Thomas Meyer, El Mehdi Kossir, Romain Beuzelin">
    
    <!-- STYLES -->
    <link rel="stylesheet" href="/css/bootstrap.min.css">
    <link rel="stylesheet" href="/css/style.css">
    
    <!-- JQuery est aussi utilisé par le jeu, donc doit être chargé avant. -->
    <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
    
  </head>
  
  <!-- BODY -->
  <body>
    
    <!-- NAVBAR -->
    <?php include_once 'navbar.php'; ?>

    <?php if (isset($data["message"])) : ?>
        <div class="alert alert-primary fixed-top m-3  " role="alert">
          <?= $data["message"] ?>
          <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    <?php endif; ?>
