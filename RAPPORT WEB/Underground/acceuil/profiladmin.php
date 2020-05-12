<?php
session_start();
?>

<?php

try{
    $db = new PDO("mysql:host=localhost;dbname=essai", "root", "root");

    

    

} catch(PDOException $e){
    die('Erreur: '.$e->getMessage());
}
?>

<?php 


//cette page doit safficher si l'utilisateur est connecté
/*if(!isset($_SESSION['user_id']) && !isset($_SESSION['pseudo'])){
  header("Location:../acceuil/connexion.php");
  exit();
}*/





?>


<?php
extract($_post);
$q = $db->prepare('SELECT (name, pseudo, email, password, city, country, soundcloud, deezer, apple, spotify, twitter, facebook, instagram, bio, dispo, role, tarif) FROM users WHERE (id = :identifiant)');
$q->execute([
    'identifiant' => $_SESSION['user_id']
    
]);

$userHasBeenFound= $q->rowCount();
if(userHasBeenFound){
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
    
}
else{
$errors[]="La combinaison identifiant/mot de passe est invalide";

}
  


?>

<!doctype html>
<html lang="fr">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="Réseau social pour Rappeur">
    <meta name="author" content="Azzouz Zakaria et Choufani Adam">
   
    <title>Page de Profil</title>


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
  <a class="navbar-brand" href="actualite.php">Underground Social Network</a>
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



<!------ Include the above in your HEAD tag ---------->

<hr class="">
<div class="container target">
    <div class="row">
        <div class="col-sm-10">
             <h1 class=""><?php echo '<div class="bg_danger">';
        
        echo Administrateur.'<br/>'; 
        ?> </h1>
         <button type="button" class="btn btn-info">Send me a message</button>
          
<br>
        </div>
      
    </div>
  <br>
    <div class="row">
        <div class="col-sm-3">
            <!--left col-->
            <ul class="list-group">
                <li class="list-group-item text-muted" contenteditable="false">Profile</li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Dispo</strong></span> 
                <?php echo '<div class="bg_danger">';
        
                      echo $dispo.'<br/>'; 
                      ?> 
                      </li>
                <li class="list-group-item text-right"><span class="pull-left"><strong class="">Localistaion</strong></span> <?php echo $city ?></li>
                    <li class="list-group-item text-right"><span class="pull-left"><strong class="">Email</strong></span>  <?php echo $email ?></li>
              <li class="list-group-item text-right"><span class="pull-left"><strong class="">Role</strong></span> <?php echo $role ?>
              <li class="list-group-item text-right"><span class="pull-left"><strong class="">Tarif</strong></span> <?php echo $tarif ?>
                      </li>
            </ul>
           <div class="panel panel-default">
             <div class="panel-heading">Réseaux

                </div>
                <div class="panel-body"><a href="$facebook" class="">Facebook</a></br>
                <div class="panel-body"><a href="$instagram" class="">Instagram</a></br>
                <div class="panel-body"><a href="$twitter" class="">Twitter</a></br>
                </div>
            </div>
            <div class="panel panel-default">
                <div class="panel-heading">Soundcloud<i class="fa fa-link fa-1x"></i>

                </div>
                <div class="panel-body"><a href="$soundcloud" class=""><?php echo $souncloud ?></a>

                </div>
            </div>
          
           
            <div class="col-sm-9" style="" contenteditable="false">
            <div class="panel panel-default">
                <div class="panel-heading">Biographie</div>
                <div class="panel-body"> <?php echo $bio ?>

                </div>
            </div>
        </div>
        
</div></div>


          
                
        
        

</main>
<link href="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.3.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script><!-- /.container -->
<script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
      <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>
      </body>
</html>