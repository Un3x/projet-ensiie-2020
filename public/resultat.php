<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style/style2.css">
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
         <img src="style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="accueil.php">Accueil</a>
	 <?php
	 if(isset($_SESSION['username'])){   
	    $link_profil="profil.php?id=".$user."";
	    echo "<a href='".$link_profil."'>Mon Profil</a>";
	 }
	 ?>
	 <a href="contact/contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=index.php?state=0>Déconnexion</a>";
	 }
	 else{
	    echo "<a href=index.php>Connexion</a>";
	 }
	 ?>
         </div>
        </div>
        <div id="container">
            <?php
               session_start();
	       $lignes=$_SESSION['nom'];
	       echo "Vous cherchez les sujets suivants:";
	       foreach ($lignes as $ligne) {
	         $id = $ligne[1];
	         $link_address="suj_corr/sujet.php?id=".$id."";
	         echo "<br><a href='".$link_address."'>".$ligne[0]."</a>";
	       }
               ?>
        </div>
    </body>
</html>
