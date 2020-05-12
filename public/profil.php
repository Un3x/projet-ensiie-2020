<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="style/style2.css">
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
            ?>
         <img src="style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="accueil.php">Accueil</a>
	 <?php
	 if(isset($_SESSION['username'])){   
	    $link_profil="profil.php?id=".$user."";
	    if ($_GET["id"]==$user){
	    echo "<a class=active href='".$link_profil."'>Mon Profil</a>";
	    }
	    else{
	    echo "<a href='".$link_profil."'>Mon Profil</a>";
	    }
	 }
	 ?>
	 <a href="contact/contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=index.php?state=0>Déconnexion</a>";
	 }
	 ?>
         </div>
        </div>
        <div id="container">
            <?php
	       $id=$_GET["id"];
	       $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');
	       $selectuser= "SELECT DISTINCT user_id, filiere, niveau, photo FROM utilisateur WHERE user_id ='$id';";
	       $exec_requete1 = pg_query($selectuser)
		      or die('Erreur commande générale');
	       if(pg_num_rows($exec_requete1) > 0)
               {
	   	 $row1 = pg_fetch_array($exec_requete1);
		 $niveau=$row1['niveau'];
	         $filiere=$row1['filiere'];
	         $photo=$row1['photo'];
               }
               else
               {
		 header('Location: resultat.php?erreur=1');
               }
	       if ($photo != ""){
	         echo "<img src=Photos/".$photo." alt='photo' style='width:120px;height:150px;'></br>";
	       }
	       echo "<b>Pseudo:</b> $id </br>";
	       if ($niveau != ""){
	         echo "<b>Niveau:</b> $niveau </br>";
	       }
	       if ($filiere != ""){
	         echo "<b>Filière:</b> $filiere </br></br>";
	       }
	       echo "<b>Les publications:</b></br>";
	       $selectpubli= "SELECT DISTINCT id, nom FROM sujet WHERE utilisateur ='$id';";
	       $exec_requete2 = pg_query($selectpubli)
		      or die('Erreur commande recherche de publications de cet utilisateur');
	       if(pg_num_rows($exec_requete2) > 0)
               {
	       
	         while($row2 = pg_fetch_array($exec_requete2)) {
	              $idsujet=$row2['id'];
		      $link_address="sujet.php?id=".$idsujet."";
	              echo "<br><a href='".$link_address."'>".$row2['nom']."</a>";
	         }

	    }
	       echo "<br><br><br><div class=bouton>";
	       if ($id==$user || $admin==1){
	                echo "<input type=button id=recherche value='Supprimer Compte' onClick=window.location.href='accueil.php?deleteuser=".$id."'>";
	       }
	       if ($id!=$user && $admin==1){
	      echo "<input type=button id=recherche value='Rendre administrateur' onClick=window.location.href='accueil.php?makeadmin=".$id."'>";}
	    if($id==$user){
	    echo "<input type=button id=recherche value='Modifier informations' onClick=window.location.href='compte/modif_compte.php'>";
	      }
	      echo "</div>";
	              
	       pg_close($db); 
               ?>
        </div>
    </body>
</html>
