<?php
if(isset($_POST["Envoyer"])){
  session_start();
  $username = $_SESSION['username'];
  if ($username==NULL){
      header('Location: depot.php?erreur=3');
      exit();
  }
  $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
           or die('Erreur de connexion  la base de données');
	   
  $fileName=$_FILES["sujet"]["name"];
  $fileSize=$_FILES["sujet"]["size"]/1024;
  $fileType=$_FILES["sujet"]["type"];
  $fileTmpName=$_FILES["sujet"]["tmp_name"];  

  if($fileType=="application/pdf" || $fileType=="image/jpeg" || $fileType=="image/png || application/vnd.oasis.opendocument.text"){
    if($fileSize<=2000){
    
      //New file name
      $newFileName=$fileName;

      //File upload path
      $uploadPath="../Sujets/".$newFileName;
      $matiere = $_POST['Matière'];
      $annee = $_POST['annee'];

      if (isset($_POST['filiere'])){
      	 $filiere = $_POST['filiere'][0];
      }
      else{
        $filiere="";
      }


      if (isset($_POST['concours'])){
      	 $concours = $_POST['concours'][0];
      }
      else{
        $concours="";
      }


      $themeP = $_POST['themeP'];
      $themeM = $_POST['themeM'];
      $themeI = $_POST['themeI'];
      print_r($themeI);
      if ($matiere == "Choisir Matière"){
       	 header('Location: depot.php?erreur=1');
      }
      if ($annee == "Choisir Année"){
         $annee="";
      }

      if(($matiere !== "") || ($annee !== "") || ($filiere !== "") || ($concours != "") )
      {
	$insert = "INSERT INTO sujet(nom,utilisateur,matiere,annee,filiere,concours,themes) VALUES ('$newFileName','$username'";
	if ($matiere !== ""){
	   $insert="".$insert.",'$matiere' ";
	}
	if ($annee !== ""){
	   $insert="".$insert.",'$annee' ";
	}
	else{
	   $insert="".$insert.",NULL ";
	}
	if ($filiere !== ""){
	   $insert="".$insert.",'$filiere' ";
	}
	else{
	   $insert="".$insert.",NULL ";
	}
	if ($concours !== ""){
	   $insert="".$insert.",'$concours' ";
	}
	else{
	   $insert="".$insert.",NULL ";
	}
	
      //function for upload file
      if(move_uploaded_file($fileTmpName,$uploadPath)){
        if ( empty($themeM) && empty($themeP) && empty($themeI) ){
	   $insert2="".$insert.",NULL); ";
	   $exec_requete = pg_query($insert2)
		      or die('Erreur commande insértion fichier dans base de données!');
	}
	else{
		if (!empty($themeM)){
			foreach ($themeM as $theme) {
			    $insert2="".$insert.",'$theme'); ";
	   		    $exec_requete = pg_query($insert2)
		      	    	or die('Erreur commande insértion fichier dans base de données!');
				}
		}
		if (!empty($themeP)){
			foreach ($themeP as $theme) {
			    $insert2="".$insert.",'$theme'); ";
	   		    $exec_requete = pg_query($insert2)
		      	    	or die('Erreur commande insértion fichier dans base de données!');
				}
		}
		if (!empty($themeI)){
			foreach ($themeI as $theme) {
			    $insert2="".$insert.",'$theme'); ";
	   		    $exec_requete = pg_query($insert2)
		      	    	or die('Erreur commande insértion fichier dans base de données!');
				}
		}
	}	
	echo "Successful"; 
        echo "File Name :".$newFileName; 
        echo "File Size :".$fileSize." kb"; 
        echo "File Type :".$fileType;
	header('Location: depot.php?id=1');
      }
    }}
    else{
      header('Location: depot.php?erreur=1');
    }
  }
  else{
    header('Location: depot.php?erreur=2');
  }  
}
else
{
   header('Location: depot.php');
}
pg_close($db); 
?> 