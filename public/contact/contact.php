<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style2.css"/>
  </head>
  <body>
    <div id="header" class="header">
      <?php
         session_start();
         if(isset($_SESSION['username'])){
         $user = $_SESSION['username'];
         echo "<div style='position:relative; top:0px; right:0px; text-align:right;'>Bonjour $user, vous êtes connecté</div>";
	 }
         ?>
      <img src="../style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="../accueil.php">Accueil</a>
	 <?php
	 if(isset($_SESSION['username'])){   
	    $link_profil="../profil.php?id=".$user."";
	    echo "<a href='".$link_profil."'>Mon profil</a>";
	 }
	 ?>
	 <a class="active" href="contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=../index.php?state=0>Déconnexion</a>";
	 }
	 else{
	    echo "<a href=../index.php>Connexion</a>";
	 }
	 ?>
         </div>
        </div>
    <div id="container">
      <form action="sendcontact.php" id="contact" method="POST">
	
        <h1>Nous contacter</h1>
	
        <label><b>Nom:</b></label>
        <input type="text" placeholder="Nom" name="name"  required>

        <label><b>Adresse mail:</b></label>
        <input type="text" placeholder="Mail" name="mail" required>

	<br>

	<label><b>Message: <br> </b></label>
	<textarea rows="8" cols="50" name="message" id="message" form="contact" placeholder="Votre message" required></textarea>

	<input type="submit" value="Envoyer">
      </form>
    </div>
  </body>
</html>
