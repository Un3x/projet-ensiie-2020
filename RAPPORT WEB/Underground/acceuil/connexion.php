<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=essai", "root", "root");

    

    

} catch(PDOException $e){
    die('Erreur: '.$e->getMessage());
}
?>
<?php
session_start();
?>
<?php
/*if(isset($_SESSION['user_id']) && isset($_SESSION['pseudo'])){
  header("Location:../acceuil/profil.php");
  exit();
}*/
?>

<?php
if(isset($_POST['login'])) {

   
      
    if(!empty($_POST['identifiant']) && !empty($_POST['password'])){
      extraxt($_POST);
      $errors = [];
      $q = $db->prepare('SELECT id, pseudo FROM users WHERE (pseudo = :identifiant) AND password = :password');
      $q->execute([
          'identifiant' => $identifiant,
          'password' => sha1($password)
      ]);
      $user = $q->fetch();
      $userHasBeenFound= $q->rowCount();
      if($userHasBeenFound>0){
          
          
          $_SESSION['user_id']=$user['id'];//un utilisateur est connecté si Session n'est pas vide
          $_SESSION['pseudo']=$user['pseudo'];
          
          /*header("Location:../acceuil/profil.php");*/
          
      }
      else{
      $errors[]="La combinaison identifiant/mot de passe est invalide";
  
    }
        
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
    
    <title>Connexion</title>

   

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
      <li class="nav-item active">
        <a class="nav-link" href="connexion.php">Connexion<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="inscription.php">Inscription</a>
      </li>
      
    </ul>
    <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-secondary my-2 my-sm-0" type="submit">Search</button>
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
    
    <h1>Connexion</h1>
   
    
    <form method="post" class="well col-md-9 col-md-offset-3">
        <!-- identifiant field -->
      <label class="control-label" for="identifiant">Pseudo/Adresse éléctronique:</label>
      <input type="text" class="from-control" id="indentifiant" name="identifiant"
        required="required"/></br>
      
    

      <!-- Mot de passe field -->
      <label class="control-label" for="password">Mot de passe:</label>
      <input type="password" class="from-control" id="password" name="password"
        required="required"/></br>
     
    
      
  </div>
  <input type="submit" class="btn btn_primary" value="Connexion" name="login"/>

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      </body>
</html>