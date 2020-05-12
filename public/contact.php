<!DOCTYPE html>
<?php session_start(); ?>
<html>
  <head>
    <meta charset="utf-8">
    <title>Projet web EpicEvry</title>
    <meta name="description" content="Projet web Ensiie">
    <meta name="author" content="Us">
    <?php include "./css_head.html" ?>
    <link rel="stylesheet" href="css/contact.css">
</head>
<body style="background-color:#677179">
<?php include "./header.html" ?>  
<br />
<div class="container2x">

<div class="row">
  <div class="column">
    <img src="logo2.png" style="width:100%">
    <div style="text-align:center">
    <h2>Contactez-nous</h2>
          <p id="mess">Si vous avez des questions, des réclamations ou même des suggestions <br /> à nous communiquer, n'hésitez pas à nous contacter via ce formulaire.</p>
    </div>
    </div>
<div class="column">
<form action="/action_page.php">
<label for="fname">Prénom</label>
<input type="text" id="fname" name="firstname" placeholder="Votre prénom...">
<label for="lname">Nom</label>
<input type="text" id="lname" name="lastname" placeholder="Votre nom...">
<label for="country">Pays</label>
<input type="text" id="country" name="namecountry" placeholder="Votre pays...">
<label for="subject">Sujet</label>
<textarea id="subject" type="text" name="messagesubject" placeholder="Votre message..." style="height:170px"></textarea>
<input type="submit" value="Envoyer">
</form>
</div>
</div>
</div>
<br />
</body>
<?php include "./footer.html" ?>
</html>
