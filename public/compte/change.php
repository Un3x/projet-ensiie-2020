<?php
session_start();
if(isset($_POST['newname']))
{
  $newname = $_POST['newname'];
  $username = $_SESSION['username'];
  //Verification d'inegalite des noms
  if ($newname == $username){
      header('Location: modif_compte.php?erreur=1');
  }

   // connexion à la base de données
   $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
   or die('Erreur de connexion  la base de données');

  // Verification de non existence du pseudo
   $idem= "Select count(*) from utilisateur where user_id = '$newname' ; ";
   $number_same_tab = pg_query($idem) or die('Erreur commande idem');
   $number_same = pg_fetch_row($number_same_tab);
   if (0 < $number_same[0]){ 
      header('Location: modif_compte.php?erreur=1');
      }

   $modif ="UPDATE utilisateur SET user_id = '$newname' WHERE user_id='$username';";

   $exec_requete = pg_query($modif) or die('Erreur commande modif');

   pg_close($db);

   $_SESSION['username']=$newname;
   
   header('Location: ../accueil.php?id=1');      
   exit();
}



if(isset($_POST['MDP']) && (isset($_POST['MDP2'])) && (isset($_POST['mdp_curr'])))
{
  $username = $_SESSION['username'];
  $MDP = $_POST['MDP'];
  $MDP2 = $_POST['MDP2'];
  $mdp_actuel = $_SESSION['password'];
  $mdp_entre = $_POST['mdp_curr'];

 //Verification d'egalite de l'ancien mdp
  if ($mdp_entre !== $mdp_actuel){
      header('Location: modif_compte.php?erreur=2');
      exit();
  }

  //Verification d'egalite du nouveau MDP
  if ($MDP !== $MDP2){
      header('Location: modif_compte.php?erreur=3');
      exit();
  }

   // connexion à la base de données
   $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
   or die('Erreur de connexion  la base de données');

   $modif ="UPDATE utilisateur SET password = '$MDP' WHERE user_id='$username';";

   $exec_requete = pg_query($modif) or die('Erreur commande modif');

   pg_close($db); 
   
   header('Location: ../accueil.php?id=1');      
   exit();
}




if(isset($_FILES['photo']) && $_FILES["photo"]["error"] == 0){
   $username = $_SESSION['username'];
   $dossier = '../Photos/';
   $fichier = $username;
   $taille_maxi = 5000000;
   $taille = filesize($_FILES['photo']['tmp_name']);
   $extensions = array('.png', '.gif', '.jpg', '.jpeg');
   $extension = strrchr($_FILES['photo']['name'], '.');
   $fichier = $username . $extension;
   $supression = "../Photos/" . $fichier;

     //Supprime si existant
   if( file_exists ( $supression))
     unlink($supression) ;
   //Début des vérifications de sécurité...
   if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
   {
	 header('Location: modif_compte.php?err=1');      
   	 exit();
   }
   if($taille>$taille_maxi)
   {
     header('Location: modif_compte.php?err=1');      
     exit();
     }
   if(!isset($erreur)) //S'il n'y a pas d'erreur, on upload
    {
     //On formate le nom du fichier ici...
     $fichier = strtr($fichier, 
          'ÀÁÂÃÄÅÇÈÉÊËÌÍÎÏÒÓÔÕÖÙÚÛÜÝàáâãäåçèéêëìíîïðòóôõöùúûüýÿ', 
          'AAAAAACEEEEIIIIOOOOOUUUUYaaaaaaceeeeiiiioooooouuuuyy');
     $fichier = preg_replace('/([^.a-z0-9]+)/i', '-', $fichier);
     move_uploaded_file($_FILES['photo']['tmp_name'], $dossier . $fichier);

// connexion à la base de données
   $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
   or die('Erreur de connexion  la base de données');

   $modif ="UPDATE utilisateur SET photo = '$fichier' WHERE user_id='$username';";

   $exec_requete = pg_query($modif) or die('Erreur commande modif');

   pg_close($db); 
   }
   header('Location: ../accueil.php?id=1');      
   exit();
  }




else{header('Location: ../accueil.php?err=1');}
?>