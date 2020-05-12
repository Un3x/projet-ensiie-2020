<?php
session_start();
if(isset($_POST['username']) && isset($_POST['password']) && isset($_POST['password2'])
			     && isset($_POST['question']) && isset($_POST['answer']))
{
  $username = $_POST['username'];
  $password = $_POST['password'];
  $password2 = $_POST['password2'];
  $question = $_POST['question'];
  $answer=$_POST['answer'];
  $mail=NULL;
  $filiere=NULL;

  // Verification des informations
  if(isset($_POST['email'])){
    $email=$_POST['email'];
  }

  if(isset($_POST['filiere'])){
  $filiere=$_POST['filiere'];
  }
  
  //Verification d'egalite des mots de passe
  if ($password !== $password2){
      header('Location: ../enr1.php?erreur=1');
  }

 if ($answer == "Choisir Question"){
      header('Location: ../enr1.php?erreur=3');
  }

   // connexion à la base de données
   $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
   or die('Erreur de connexion  la base de données');

  // Verification de non existence du pseudo
   $idem= "Select count(*) from utilisateur where user_id = '$username' ; ";
   $number_same_tab = pg_query($idem) or die('Erreur commande idem');
   $number_same = pg_fetch_row($number_same_tab);
   if (0 < $number_same[0]){ 
      header('Location: ../enr1.php?erreur=2');
      }
 $fichier=NULL;
 if (isset($_FILES['photo']) && $_FILES["photo"]["error"] == 0){
   $dossier = '../Photos/';
   $fichier = $username;
   $taille_maxi = 5000000;
   $taille = filesize($_FILES['photo']['tmp_name']);
   $extensions = array('.png', '.gif', '.jpg', '.jpeg');
   $extension = strrchr($_FILES['photo']['name'], '.');
   $fichier = $username . $extension;
   //Début des vérifications de sécurité...
   if(!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
   {
	 header('Location: enr1.php?err=4');      
   	 exit();
   }
   if($taille>$taille_maxi)
   {
     header('Location: enr1.php?err=5');      
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
     
   }
  }

   $create = "Insert into utilisateur values('$username','$password','$question','$answer','$email','$filiere',NULL,'$fichier');";
   $exec_requete = pg_query($create) or die('Erreur commande create');

   pg_close($db);

  
   header('Location: ../index.php?id=1');      
   exit();
}
else{header('Location: ../index.php');}
?>