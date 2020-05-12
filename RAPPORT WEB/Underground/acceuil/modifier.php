<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=socialnet", "root", "root");

    

    

} catch(PDOException $e){
    die('Erreur: '.$e->getMessage());
}
?>


<?php


if(isset($_POST['register'])) {
    $g = $_SESSION['user_id'];
  extract($_POST);
      
  
    $p = $db->prepare('INSERT INTO users(city, country, twitter, instagram, facebook, soundcloud, spotify, deezer, apple, bio) WHERE (id = $g) VALUES(:city, :country, :twitter, :instagram, :facebook, :soundcloud, :spotify, :deezer, :apple, :bio)');
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
          'bio' => $bio
      ]);
      header("Location:../acceuil/profil.php");
    }
        


  
      

?>

<?php
$q = $db->prepare('SELECT (name, pseudo, email, password, city, country, soundcloud, deezer, apple, spotify, twitter, facebook, instagram, bio, dispo, role, tarif) FROM users WHERE (id = :identifiant)');
$q->execute([
    'identifiant' => $_SESSION['user_id']
    
]);

$userHasBeenFound= $q->rowCount();

$connect = $q->fetch(PDO::FETCH_OBJ);
    
$city=$connect->city;//un utilisateur est connecté si Session n'est pas vide
$country=$connect->country;
$name=$connect->name;  
$pseudo=$connect->pseudo;    
$name=$connect->name;
$email=$connect->email;
$soundcloud=$connect->souncloud;
$deezer=$connect->deezer;
$apple=$connect->apple;
$spotify=$connect->spotify;
$twitter=$connect->twitter;
$facebook=$connect->facebook;
$instagram=$connect->instagram;
$bio=$connect->bio;
$dispo=$connect->dispo;
$role=$connect->role;
$tarif=$connect->tarif;
    


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
    
      <li class="nav-item active">
        <a class="nav-link" href="profil.php">Profil<span class="sr-only">(current)</span></a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="actualite.php" >Fil d'actualité</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="partager.php">Partager</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="logout.php">Deconnexion</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="recherche.php">Recherche</a>
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
        value="<?php echo $city?>"/></br>
      
      <!-- pays field -->
      <label class="control-label" for="country">Pays:</label>
      <input type="text" class="from-control" id="country" name="country"
        required="required" value="<?php echo $country?>"/></br>
      
      <!-- reseau social field -->
      <label class="control-label" for="twitter">Twitter:</label>
      <input type="link" class="from-control" id="twitter" name="twitter"
        required="required" value="<?php echo $twitter?>"/></br>

      
      <label class="control-label" for="instagram">Instagram:</label>
      <input type="link" class="from-control" id="instagram" name="instagram"
        required="required" value="<?php echo $instagram?>"/></br>

        
      <label class="control-label" for="facebook">Facebook:</label>
      <input type="link" class="from-control" id="facebook" name="facebook"
        required="required" value="<?php echo $city?>" value="<?php echo $facebook?>"/></br>
     
     
      <label class="control-label" for="soundcloud">Soundcloud:</label>
      <input type="link" class="from-control" id="soundcloud" name="soundcloud"
        required="required" value="<?php echo $soundcloud?>"/></br>

      
      <label class="control-label" for="spotify">Spotify:</label>
      <input type="link" class="from-control" id="spotify" name="spotify"
        required="required" value="<?php echo $spotify?>"/></br>
    
      
      <label class="control-label" for="deezer">Deezer:</label>
      <input type="link" class="from-control" id="deezer" name="deezer"
        required="required" value="<?php echo $deezer?>"/></br>

       
      <label class="control-label" for="apple">Apple Music:</label>
      <input type="link" class="from-control" id="apple" name="apple"
        required="required" value="<?php echo $apple?>"/></br>

      
      <label class="control-label" for="role">Rôle dans la musique:</label>
      <input type="link" class="from-control" id="role" name="role"
        required="required" value="<?php echo $role?>"/></br>
        
      <label class="control-label" for="tarif">Tarif:</label>
      <input type="link" class="from-control" id="tarif" name="tarif"
        required="required" value="<?php echo $tarif?>"/></br>

       <!-- Name field -->
       <label class="control-label" for="name">Nom:</label>
      <input type="text" class="from-control" id="name" name="name"
        required="required" value="<?php echo $name?>"/></br>
      
      <!-- Pseudo field -->
      <label class="control-label" for="pseudo">Pseudo:</label>
      <input type="text" class="from-control" id="pseudo" name="pseudo"
        required="required" value="<?php echo $pseudo?>"/></br>



      <label class="control-label" for="bio">Biographie:</label>
      <input type="text" class="from-control" id="bio" name="bio"
        required="required" value="<?php echo $bio?>"/></br>
      
  </div>
  <input type="submit" class="btn btn_primary" value="Valider" name="register"/>

</main><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      </body>
</html>