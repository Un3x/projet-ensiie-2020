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
      <?php 
           session_start();
	   $password=$_POST['password'];
	   $question=$_POST['question'];
	   $answer=$_POST['answer'];
	   $user=$_POST['user'];?>
	<div id="container">
            <form action="reponse2.php" method="POST">
	      <label><b>Nom d'utilisateur</b></label>
	      <?php echo $user; ?>
	      </br>
	      <label><b>Question:</b></label>
	      <?php echo $question ?>
	      </br>
                <input type="text" placeholder="Réponse" name="reponse1" required>
		<input type="hidden" name="reponse2" value="<?php echo $answer?>">
		<input type="hidden" name="password" value="<?php echo $password?>">
		</br>
                <input type="submit" id='submit' value='Valider' >
	    </form>
      </div>
    </body>
</form>
    
</html>
