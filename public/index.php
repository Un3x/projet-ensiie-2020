<!DOCTYPE html>
<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Aliment.php';
include '../src/AlimentRepository.php';

include '../src/Factory/DbAdaperFactory.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$alimentRepository = new \Aliment\AlimentRepository($dbAdaper);
$aliments = $alimentRepository->fetchall();
session_start();

?>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>EpicEvry</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Us">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
	<?php if(isset($_SESSION['id'])): ?>
    <link rel="stylesheet" href="css/header_connected.css">
<?php else: ?>
	<link rel="stylesheet" href="css/header_disconnected.css">
<?php endif ?>
    <link rel="stylesheet" href="css/accueil.css">
<link rel="stylesheet" href="css/footer.css">
    <link rel="stylesheet" href="css/normalize.css">
<link href="https://fonts.googleapis.com/css2?family=Roboto:ital,wght@1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">

    <body>
      <?php include "./header.html" ?>
    <div class="hero" style="background-image: url(https://ununsplash.imgix.net/photo-1416339134316-0e91dc9ded92?q=75&fm=jpg&s=883a422e10fc4149893984019f63c818)">
      <h1>EpicEvry: au service des étudiants</h1>
      <div class="hero__content">
	<a class="btn" href="/page_inscription.php">Inscrivez-vous !</a>
      </div>
    </div>
  </body>
  <?php include "./footer.html" ?>

</html>
