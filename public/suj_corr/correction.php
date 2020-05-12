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
	 $id=$_GET['id'];
	 ?>
      <form action="uploadcorrection.php?id=<?php echo $id ?>" method="post" enctype="multipart/form-data">
	Choisissez le fichier de correction à envoyer:
	<input type="file" name="correction" id="correction">
	<div class="bouton" style="margin-top:20px;">
	<input type="submit" id="Envoyer" value="Envoyer" name="Envoyer">
	</div>
        <?php     
           if(isset($_GET['erreur'])){
           $err = $_GET['erreur'];
           if($err==1){
           echo "<p style='color:red'>La taille du fichier ne peut pas dépasser 2Mo. </p>";
	   }
	   if($err==2){
           echo "<p style='color:red'>Choisissez un fichier de type : pdf, jpeg, png, odt. </p>";
	   }
           }
           ?>
      </form>
    </div>
  </body>
</html>
