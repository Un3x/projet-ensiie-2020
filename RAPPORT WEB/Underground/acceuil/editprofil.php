<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=essai", "root", "root");

    

    

} catch(PDOException $e){
    die('Erreur: '.$e->getMessage());
}
?>


<?php


if(isset($_POST['register'])) {
    
  extract($_POST);
      
  
  $p = $db->prepare('INSERT INTO profil(city, country, twitter, instagram, facebook, soundcloud, spotify, deezer, apple, bio, role, tarif, name, pseudo) VALUES(:city, :country, :twitter, :instagram, :facebook, :soundcloud, :spotify, :deezer, :apple, :bio, :role, :tarif, :name, :pseudo)');
    $p -> execute([
        'city'=> $city,
        'country' => $country,
        'twitter' => $twitter,
        'instagram' => $instagram,
        'facebook' => $facebook,
        'soundcloud' => $soundcloud,
        'spotify' => $spotify,
        'deezer' => $deezer,
        'apple'=> $apple,
        'bio' => $bio,
        'role'=>$role,
        'tarif'=>$tarif,
        'name'=>$name,
        'pseudo'=>$pseudo
      ]);
      header("Location:../acceuil/profil.php");
    }  
        


  
      

?>





<!doctype html>
<html lang="fr">
  <head> 
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Réseau social pour Rappeur">
    <meta name="author" content="Azzouz Zakaria et Choufani Adam">
    
    <title>Information</title>

   

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
    
    <h1>Votre compte a bien été crée. Veuillez remplir ces informations afin que vos amis vous reconaissent.</h1>
   
    
    <form method="post" class="well col-md-9 col-md-offset-3">
        <!-- ville field -->
      <label class="control-label" for="city">Ville:</label>
      <input type="text" class="from-control" id="city" name="city"
        required="required"/></br>
      
      <!-- pays field -->
      <label class="control-label" for="country">Pays:</label>
      <input type="text" class="from-control" id="country" name="country"
        required="required"/></br>
      
      <!-- reseau social field -->
      <label class="control-label" for="twitter">Twitter:</label>
      <input type="link" class="from-control" id="twitter" name="twitter"
        required="required"/></br>

      
      <label class="control-label" for="instagram">Instagram:</label>
      <input type="link" class="from-control" id="instagram" name="instagram"
        required="required"/></br>

        
      <label class="control-label" for="facebook">Facebook:</label>
      <input type="link" class="from-control" id="facebook" name="facebook"
        required="required"/></br>
     
     
      <label class="control-label" for="soundcloud">Soundcloud:</label>
      <input type="link" class="from-control" id="soundcloud" name="soundcloud"
        required="required"/></br>

      
      <label class="control-label" for="spotify">Spotify:</label>
      <input type="link" class="from-control" id="spotify" name="spotify"
        required="required"/></br>
    
      
      <label class="control-label" for="deezer">Deezer:</label>
      <input type="link" class="from-control" id="deezer" name="deezer"
        required="required"/></br>

       
      <label class="control-label" for="apple">Apple Music:</label>
      <input type="link" class="from-control" id="apple" name="apple"
        required="required"/></br>

      <label class="control-label" for="role">Rôle dans la musique:</label>
      <input type="link" class="from-control" id="role" name="role"
        required="required"/></br>
        
      <label class="control-label" for="tarif">Tarif:</label>
      <input type="link" class="from-control" id="tarif" name="tarif"
        required="required"/></br>

       <!-- Name field -->
       <label class="control-label" for="name">Nom:</label>
      <input type="text" class="from-control" id="name" name="name"
        required="required"/></br>
      
      <!-- Pseudo field -->
      <label class="control-label" for="pseudo">Pseudo:</label>
      <input type="text" class="from-control" id="pseudo" name="pseudo"
        required="required"/></br>

      



      <label class="control-label" for="bio">Biographie:</label>
      <input type="text" class="from-control" id="bio" name="bio"
        required="required"/></br>
      
  </div>
  <input type="submit" class="btn btn_primary" value="Valider" name="register"/>

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      </body>
</html>


