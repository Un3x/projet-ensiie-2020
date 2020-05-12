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
	    $link_profil="profil.php?id=".$user."";
	    echo "<a href='".$link_profil."'>Mon Profil</a>";
	 }
	 ?>
	 <a href="../contact/contact.php">Contact</a>
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
	<?php
	  session_start();
	  $p=$_POST['password'];
	  $r1=$_POST['reponse1'];
	  $r2=$_POST['reponse2'];
	  if (isset($_POST['reponse1']) && isset($_POST['reponse2'])){
	     if (($_POST['reponse1'])==($_POST['reponse2'])){
	     echo "<p>Le mot de passe est: <p>", $p;}
	else {echo "<p>Erreur : mauvaise réponse </p>";}}
	else {echo "<p>Erreur grave : contactez les admins</p>";}?>
	<form action="../index.php" method="POST">
	  <input type="submit" id='submit' value='Retour au menu'>
	    </form>
      </div>
    </body>
</form>
</html>
