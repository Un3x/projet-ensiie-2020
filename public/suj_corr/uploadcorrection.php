<?php
if(isset($_POST["Envoyer"])){
  $id = $_GET["id"];
  session_start();
  $username = $_SESSION['username'];
  $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
           or die('Erreur de connexion  la base de données');
	   
  $fileName=$_FILES["correction"]["name"];
  $fileSize=$_FILES["correction"]["size"]/1024;
  $fileType=$_FILES["correction"]["type"];
  $fileTmpName=$_FILES["correction"]["tmp_name"];  

  if($fileType=="application/pdf" || $fileType=="image/jpeg" || $fileType=="image/png || application/vnd.oasis.opendocument.text"){
    if($fileSize<=2000){
    
      //New file name
      $random=rand(1111,9999);
      $newFileName=$random.$fileName;

      //File upload path
      $uploadPath="../Corrections/".$newFileName;

      //function for upload file
      if(move_uploaded_file($fileTmpName,$uploadPath)){
        $insert = "INSERT INTO correction(id,nomcorrection,utilisateur) VALUES ('$id','$newFileName','$username');";
	$exec_requete = pg_query($insert)
		      or die('Erreur commande insértion fichier dans base de données!');
        echo "Successful"; 
        echo "File Name :".$newFileName; 
        echo "File Size :".$fileSize." kb"; 
        echo "File Type :".$fileType;
	header('Location: recherche.php');
      }
    }
    else{
      header('Location: correction.php?erreur=1');
    }
  }
  else{
    header('Location: correction.php?erreur=2');
  }  
}
else
{
   header('Location: correction.php');
}
pg_close($db); 
?> 