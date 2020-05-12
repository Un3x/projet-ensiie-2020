<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=essai", "root", "root");

    

    

} catch(PDOException $e){
    die('Erreur: '.$e->getMessage());
}
?>
<?php


if(isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])){
  header("Location:../acceuil/profil.php");
  exit();
}
?>

<?php
session_start();
if(isset($_POST['register'])) {

   
      
  if(!empty($_POST['name']) && !empty($_POST['pseudo']) && !empty($_POST['email']) && !empty($_POST['password_confirm']) && !empty($_POST['password'])){
    $errors = [];
    extract($_POST);
    
    if(mb_strlen($pseudo)<3){
      $errors[] = "Veuillez entrer un pseudo avec plus de caractères(min 3)";
    }
    if(mb_strlen($password)<3){
      $errors[] = "Veuillez entrer un mot de passe avec plus de caractères(min 6)";
    }
    
      
    
    /*if(is_already_in_use('pseudo',$pseudo,'users')){
      $errors[]= "Pseudo déjà utilisé";
    }
    if(is_already_in_use('email',$email,'users')){
      $errors[]= "Email déjà utilisé";
    }*/
    
    if($password != $password_confirm){
        $errors[]="Les deux mot de passe ne concordent pas";
      }
    if(count($errors)==0){
      $q = $db->prepare('INSERT INTO users(name, pseudo, email, password) VALUES(:name, :pseudo, :email, :password)');
      $q -> execute([
          'name'=> $name,
          'pseudo' => $pseudo,
          'email' => $email,
          'password' => sha1($password)
      ]);
      header("Location:../acceuil/editprofil.php");}
   


  }
  else{
    $errors[] = "veuillez remplir tous les champs!";

  }
      
}
?>

 


<!doctype html>
<html lang="fr">
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Réseau social pour Rappeur">
    <meta name="author" content="Azzouz Zakaria et Choufani Adam">
    
    <title>Inscription</title>

   

    <!-- Bootstrap core CSS -->
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
    <link rel="stylesheet" href="assets/Css/Main.css"/>  
    <!-- Favicons -->
<link rel="apple-touch-icon" href="/docs/4.4/assets/img/favicons/apple-touch-icon.png" sizes="180x180">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-32x32.png" sizes="32x32" type="image/png">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon-16x16.png" sizes="16x16" type="image/png">
<link rel="manifest" href="/docs/4.4/assets/img/favicons/manifest.json">
<link rel="mask-icon" href="/docs/4.4/assets/img/favicons/safari-pinned-tab.svg" color="#563d7c">
<link rel="icon" href="/docs/4.4/assets/img/favicons/favicon.ico">
<meta name="msapplication-config" content="/docs/4.4/assets/img/favicons/browserconfig.xml">
<meta name="theme-color" content="#563d7c">


    <style>
      .bd-placeholder-img {
        font-size: 1.125rem;
        text-anchor: middle;
        -webkit-user-select: none;
        -moz-user-select: none;
        -ms-user-select: none;
        user-select: none;
      }

      @media (min-width: 768px) {
        .bd-placeholder-img-lg {
          font-size: 3.5rem;
        }
      }
    </style>
    <!-- Custom styles for this template -->
    <link href="starter-template.css" rel="stylesheet">
  </head>
  <body>
    <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="#">Underground Social Network</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>

  <div class="collapse navbar-collapse" id="navbarsExampleDefault">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="index1.php">Acceuil </a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="connexion.php">Connexion</a>
      </li>
      <li class="nav-item active">
        <a class="nav-link disabled" href="#" tabindex="-1" aria-disabled="true">Inscription<span class="sr-only">(current)</span></a>
      </li>
      
      
    </ul>
   
    </form>
  </div>
</nav>

<main role="main" class="container">
  

  <div class="jumbotron">
  
     <?php
    if(isset($errors) && count($errors) !=0 ){
      echo '<div class="bg_danger">';
        foreach($errors as $error){
          echo $error.'<br/>';
        }
      echo '</div>';
    }
    ?><br/>
    
    <h1>Devenez dès a présent membre!</h1>
   
    
    <form method="post" class="well col-md-9 col-md-offset-3">
        <!-- Name field -->
      <label class="control-label" for="name">Nom:</label>
      <input type="text" class="from-control" id="name" name="name"
        required="required"/></br>
      
      <!-- Pseudo field -->
      <label class="control-label" for="pseudo">Pseudo:</label>
      <input type="text" class="from-control" id="pseudo" name="pseudo"
        required="required"/></br>
      
      <!-- Email field -->
      <label class="control-label" for="email">Adresse Email:</label>
      <input type="email" class="from-control" id="email" name="email"
        required="required"/></br>

      <!-- Mot de passe field -->
      <label class="control-label" for="password">Mot de passe:</label>
      <input type="password" class="from-control" id="password" name="password"
        required="required"/></br>
     
      <!-- password confirmation field -->
      <label class="control-label" for="password_confirm">Confirmer votre mot de passe:</label>
      <input type="password" class="from-control" id="password_confirm" name="password_confirm"
        required="required"/>

      
      
  </div>
  <input type="submit" class="btn btn_primary" value="Inscription" name="register"/>

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      </body>
</html>


