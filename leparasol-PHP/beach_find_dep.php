<?php session_start()?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Parasol</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="find.css">
    <link rel="stylesheet" href="beach_find.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bulma@0.8.0/css/bulma.min.css">
    <link rel="stylesheet" href="https://www.w3schools.com/w3css/4/w3.css">
    <meta name="viewport" content="width=device-width, initial-scale=1, minimum-scale=1, user-scalable=no">
    <script defer src="https://use.fontawesome.com/releases/v5.3.1/js/all.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css?family=Calligraffitti&display=swap" rel="stylesheet">
    <script src="https://kit.fontawesome.com/89999fd2c4.js" crossorigin="anonymous"></script>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
    <link href="https://fonts.googleapis.com/css?family=Comfortaa&display=swap" rel="stylesheet">
</head>

<body>
    <header class="topbar">
        <div class="row">
            <div class="col-sm-5">
               
            </div>
            <div class="col-sm-2">
                <a class="topbar-logo"> Le Parasol </a>
            </div>  
            <div class="col-sm-5">
               
            </div>
        </div>
        
        <nav class="topbar-nav">
            <a href="index.php">Accueil</a>
            <a href="find.php">Chercher une plage</a>
            <a href="speak.php" class="active">Parler d'une plage</a>
            <?php if(!(empty($_SESSION['firstname']))){
            echo '<a href="compte.php">Mon Compte</a>';}
            else {
               echo '<a href="registration.php">S inscrire/Se connecter</a>';
            }
            ?>
            <a href="contact.php">Contact</a>
        </nav>
    </header>
    <link rel="stylesheet" href="test.css">
<?php 
include('includes/dbh.inc.php');

if (isset($_GET['departement']))
{
$var1 = $_GET['departement'];
    $sql='SELECT * FROM public."Beach" WHERE departement=? ORDER BY note DESC ';
    $result = $conn->prepare($sql);
    $result->execute(array($var1));
    if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
        echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
        exit();
    }
    $result->execute(array($var1));
    while ($row = $result->fetch(PDO::FETCH_ASSOC)){ ?>
        <main class="a">
 
 
 
        <!-- Right Column -->
        <div class="right-column">
       
          <!-- Product Description -->
          <div class="product-description">
            <span><?php echo $row['departement']; echo ", "; echo $row['localisation']; ?> </span>
            <h1><?php echo $row['name_beach'] ?></h1>
            <p><?php echo $row['description'] ?>.</p>
          </div>
       
          <!-- Product Configuration -->
          <div class="product-configuration">
       
            <!-- Product Color -->
           
       
            <!-- Cable Configuration -->
            <div class="cable-config">
              <span>Caractéristiques</span>
       
              <div class="cable-choose">
                <button><?php echo $row['caracteristics'] ?></button>
                <button><?php echo $row['nudity'] ?></button>
                <button><?php echo $row['privacy'] ?></button>
              </div>
              <?php $sql1='SELECT * FROM public."Commentaire" WHERE plage=?';
              $result1 = $conn->prepare($sql1);
              $result1->execute(array($row['name_beach']));
              while ($row1 = $result1->fetch(PDO::FETCH_ASSOC)){?>
          <div class="product-description">
            <span><?php echo $row1['prenom']; echo " "; echo $row1['nom']; ?></span>
            <p><?php echo $row1['commentaire'] ?></p>
              </div> <?php }?>
            </div>
          </div>
       
          <!-- Product Pricing -->
          <div class="product-price">
            <span><?php echo round($row['note'],1), 1); echo "/5"; ?></span>
            <?php if (empty($_SESSION['firstname'])){?>
     <a href="registration.php" class="cart-btn">Poster un commentaire</a> 
     <?php }
     else {
       ?><a href="speaking.php" class="cart-btn">Poster un commentaire</a> 
       <?php }?>
          </div>
        </div>
       </main>
       <?php }?>
       <footer class="footer">
    <div class="footer__addr">
      <h1 class="footer__logo">Le Parasol</h1>
          
      <h2>Contact</h2>
      
      <address>
        91000 Evry-Courcouronnes ENSIIE<br>    
        <a class="footer__btn" href="mailto:example@gmail.com">Contactez-nous !</a>
      </address>

    </div>
    
    <ul class="footer__nav">
      <li class="nav__item">
        <h2 class="nav__title">Partenariat</h2>
  
        <ul class="nav__ul">
          <li>
            <a href="#">Notre histoire</a>
          </li>
  
          <li>
            <a href="#">Promouvoir sa ville</a>
          </li>
              
          <li>
            <a href="#">Publicités alternatives</a>
          </li>
        </ul>
      </li>
      
      <li class="nav__item nav__item-extra">
        <h2 class="nav__title">Plages</h2>
        
        <ul class="nav__ul nav__ul-extra">
          <li>
            <a href="#">Nos critères de séléction</a>
          </li>
          
          <li>
            <a href="#">Les plages les plus visitées</a>
          </li>
          
          <li>
            <a href="#">Toutes les plages recensées</a>
          </li>

        </ul>
      </li>
      
      <li class="nav__item">
        <h2 class="nav__title">Légal</h2>
        
        <ul class="nav__ul">
          <li>
            <a href="#">Politique de confidentialité </a>
          </li>
          
          <li>
            <a href="#">Conditions d'utilisation</a>
          </li>

        </ul>
      </li>
    </ul>
    
    <div class="legal">
      <p>&copy; 2020 TeamDièse. Tous droits réservés.</p>
      
      <div class="legal__links">
        <span>Made with heart by TeamDièse</span>
      </div>
    </div>
  </footer>

</body>
    <?php exit();
}
