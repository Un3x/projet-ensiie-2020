<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style/style4.css">
    </head>
    <body>
      <div class="header">
         <?php
                session_start();
                if(isset($_SESSION['username'])){
                    $user = $_SESSION['username'];
                    echo "<div style='position:relative; top:0px; right:0px; text-align:right;'>Bonjour $user, vous êtes connecté</div>";
	        }
	        $admin=0;
	        if(isset($_SESSION['admin'])){
	           $admin = $_SESSION['admin'];
	        }
	        if(isset($_GET['deleteuser']) && ($admin == 1 || $user==$_GET['deleteuser']))
	        {
	         $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');    
	         $iddelete=$_GET['deleteuser'];
	         $selectuti = "SELECT photo FROM utilisateur WHERE user_id='$iddelete'";
	         $select_requete = pg_query($selectuti)
	    or die('Erreur commande trouver sujet!');
	         $row = pg_fetch_array($select_requete);
	         $Path="Photos/".$row['photo'];
	         unlink($Path);
	         $deleteuser = "DELETE FROM utilisateur WHERE user_id='$iddelete';";
	         $delete_requete = pg_query($deleteuser)
	           or die('Erreur commande supprimer utilisateur!');
	         if ($iddelete==$user){
	           header('Location: index.php?state=0');
	         }
	        }
	        if(isset($_GET['makeadmin']) && ($admin == 1))
	        {
	         $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');    
	         $idnextadmin=$_GET['makeadmin'];
	         $makeadmin = "UPDATE utilisateur SET admin=1 WHERE user_id='$idnextadmin';";
	         $admin_requete = pg_query($makeadmin)
	           or die('Erreur commande rendre administrateur!');
	         }
            ?>
	 <img src="style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="accueil.php" class="active">Accueil</a>
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
	  <div class="bouton">
	  <input type="button" id="recherche" value="Rechercher un sujet"
		 onClick="window.location.href='recherche.php'">
          <input type="button" id="depot" value="Déposer un sujet"
		 onClick="window.location.href='suj_corr/depot.php'">
	  </div>
          </br>

	  <?php
            if(isset($_GET['err'])){
                echo "Erreur inconnue, contactez les administrateurs svp.";}
	    if(isset($_GET['id'])){
                echo "Vos nouveaux paramètres ont bien été pris en compte";}
           ?>
        </div>
	 
    </body>
</html>
