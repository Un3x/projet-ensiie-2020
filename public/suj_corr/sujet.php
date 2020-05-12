<html>
    <head>
        <meta charset="utf-8">
        <!-- importer le fichier de style -->
        <link rel="stylesheet" href="../style/style3.css">
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
	 else{
	    echo "<a href=../index.php>Connexion</a>";
	 }
	 ?>
         </div>
        </div>
        <div id="container">
            <?php
	       $id=$_GET["id"];
	       $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');
	       $selectsujet = "SELECT DISTINCT nom,id,utilisateur FROM sujet WHERE id='$id';";
	       $exec_requete4 = pg_query($selectsujet)
		      or die('Erreur commande générale');
	       if(pg_num_rows($exec_requete4) > 0)
               {
	   	 $row4 = pg_fetch_array($exec_requete4);
		 $nomsujet=$row4['nom'];
		 $utilisateursujet=$row4['utilisateur'];
               }
               else
               {
		 header('Location: ../resultat.php?erreur=1');
               }
	       echo "Vous cherchez le sujet suivant:";
	         $link_address="../Sujets/".$nomsujet."";
	         echo "<br><a href='".$link_address."'>".$nomsujet."</a>";


	       if ($row4['utilisateur']==$user || $admin==1){
	           echo "<br><br><a href=../recherche.php?deletesujet=".$id."> Supprimer Publication </a>";
	       }

	       if (isset($_SESSION['username'])){
	    echo "<br><br><a href=correction.php?id=".$id.">Proposer une correction</a>";
	       }
	    else{
	    echo "<p style='color:red;'>Connectez-vous pour proposer une correction</p>";
	       }

	       echo "<br><br><b>Corrections disponibles:</b>";
	       $selectcorrection = "SELECT DISTINCT nomcorrection,utilisateur FROM correction WHERE id='$id';";
	       $exec_correction = pg_query($selectcorrection)
	           or die('Erreur commande recherche correction');
	       if(pg_num_rows($exec_correction) > 0)
               {
	         while($row5 = pg_fetch_array($exec_correction)){
		   $nomcorrection=$row5['nomcorrection'];
	           $utilisateurcorrection=$row5['utilisateur'];
	           $link_address="../Corrections/".$nomcorrection."";
	           echo "<br><a href='".$link_address."'>".$nomcorrection."</a>";
	           echo " publiée par : ".$utilisateurcorrection.".";
	         }
	       }
	    
	    ?>
            <?php
	     
	       if(isset($_POST['comment']))
	       {
	         $username= $_SESSION['username'];
	         $commentaire= pg_escape_string($_POST['comment']);
	         $insertcommentaire = "INSERT INTO comment(idsujet,utilisateur,content) VALUES ('$id','$username','$commentaire');";
	         $exec_requete3 = pg_query($insertcommentaire)
	           or die('Erreur commande ecrire commentaire!');
	         header('Location: ../contact/mailcomment.php?id='.$id.'');
	       }

	       
	       if(isset($_POST['reply']))
	       {
	         $username= $_SESSION['username'];
	         $reponse= pg_escape_string($_POST['reply']);
	         $aqui= $_GET['repondre'];
	         $insertreponse = "INSERT INTO comment(idsujet,utilisateur,content,replyto) VALUES ('$id','$username','$reponse','$aqui');";
	         $exec_reponse = pg_query($insertreponse)
	         or die('Erreur commande ecrire commentaire!');
	       }

	       
	       if(isset($_GET['delete']))
	       {
	         $iddelete=$_GET['delete'];
	         $deletecommentaire = "DELETE FROM comment WHERE idcomment='$iddelete'";
	         $delete_requete = pg_query($deletecommentaire)
	         or die('Erreur commande supprimer commentaire!');
	       }
	       
	       $username= $_SESSION['username'];
	       $toreply=0;
	       if(isset($_GET['toreply']))
	       {
	         $toreply=$_GET['toreply'];
	       }
	       $select = "SELECT idcomment,utilisateur,content FROM comment WHERE replyto IS NULL AND idsujet='$id'; ";
	       echo "<br><br><br><h1>Les commentaires:</h1>";

	       if (isset($_SESSION['username'])){
	         echo "<div style=text-align:left;><textarea rows=4 cols=50 name=comment id=comment form=commentaire placeholder='Ajouter un commentaire'></textarea></br>
	         <form action=sujet.php?id=".$id." method=POST id=commentaire>
		   <input type=submit>
	         </form></div>";
	       }

	       $exec_requete = pg_query($select)
		      or die('Erreur commande recherche de commentaires principaux!');
	       if(pg_num_rows($exec_requete) > 0)
               {
	         while($row = pg_fetch_array($exec_requete)) {
	              echo "<a href=../profil.php?id=".$row['utilisateur'].">".$row['utilisateur']."</a> : ".$row['content']."";
	              if (isset($_SESSION['username'])){
	                if ($row['utilisateur']==$username || $admin==1){
	                  echo "<a href=sujet.php?id=".$id."&delete=".$row['idcomment']."> supprimer </a>";
	                }
	                echo "<a href=sujet.php?id=".$id."&toreply=".$row['idcomment']."> repondre </a>";
	              }
	              echo "</br>";
	              $selectreplies = "SELECT idcomment,utilisateur,content FROM comment WHERE replyto=".$row['idcomment'].";";
	              $exec_requete2 = pg_query($selectreplies)
	                   or die('Erreur commande recherche de réponses!');
	              if(pg_num_rows($exec_requete2) > 0)
                      {
	                while($row2 = pg_fetch_array($exec_requete2)) {
    	                  echo "<a href=../profil.php?id=".$row2['utilisateur'].">".$row2['utilisateur']."</a> répond à ".$row['utilisateur']." : ".$row2['content']."";
	                  if (isset($_SESSION['username'])){
	                    if ($row2['utilisateur']==$username){
	                      echo "<a href=sujet.php?id=".$id."&delete=".$row2['idcomment'].">supprimer</a>";
	                    }
	                  }
	                  echo "</br>";
	                }
	              }
	              if($row['idcomment']==$toreply){
	                echo "<textarea rows=4 cols=50 name=reply id=reply form=reponse>Ajouter une réponse</textarea></br>
	                <form action=sujet.php?id=".$id."&repondre=".$toreply." method=POST id=reponse>
		        <input type=submit>
	                </form>";
		      }
		 }
	       }
	    pg_close($db); 
            ?>
        </div>
    </body>
</html>
