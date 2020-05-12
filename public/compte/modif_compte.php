<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style2.css"/>
  </head>
  <body>
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
	    echo "<a href='".$link_profil."'>Mon Profil</a>";
	 }
	 ?>
	 <a href="../contact/contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=../index.php?state=0>Déconnexion</a>";
	 }
	 ?>
         </div>
        </div>
    <div id="container">
      <?php
	 session_start();
	 $username = $_SESSION['username'];
	 ?>

      <form action="change.php" method="POST">
        <h1>Modifier le nom</h1>
        <input type="text" placeholder="Nouveau nom" name="newname" required>
        <input type="submit" id='submit' value='Changer' >	
      </form>

      <form action="change.php" method="POST">
        <h1>Modifier le mot de passe</h1>
	<input type="password" placeholder="" name="mdp_curr" required>
	<input type="password" placeholder="Nouveau MDP" name="MDP" required>
	<input type="password" placeholder="Nouveau MDP" name="MDP2" required>
	<input type="submit" id='submit' value='Changer' >
      </form>

      <form action="change.php" method="POST" enctype="multipart/form-data">
        <h1>Modifier l'image</h1>
	<input type="file" name="photo" id="Photo">
	<input type="submit" id='submit' value='Changer' >
      </form>
      
      
      <?php
         if(isset($_GET['erreur'])){
         $err = $_GET['erreur'];
         if($err==1){
         echo "<p style='color:red'>Nom d’utilisateur déjà utilisé&#8239;</p>";}
         if($err==2){
         echo "<p style='color:red'> Mdp courant faux </p>";}
         if($err==3){
         echo "<p style='color:red'>Mots de passe différents&#8239;</p>";}
	 if($err==4)
         echo "<p style='color:red'>Mauvaise extension de fichier. </p>";
         if($err==5)
         echo "<p style='color:red'>Le fichier est trop lourd&#8239;!</p>";}
         ?>

    </div>
  </body>
</form>

</html>
