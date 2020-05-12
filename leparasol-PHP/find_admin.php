<?php session_start();?>
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
            <a href="index_admin.php">Accueil</a>
            <a href="find_admin.php">Chercher une plage</a>
            <a href="speak_admin.php" class="active">Parler d'une plage</a>
            <?php if(isset($_SESSION['firstname'])){
            echo '<a href="compte_admin.php">Mon Compte</a>';}
            else {
               echo '<a href="registration.php">S inscrire/Se connecter</a>';
            }
            ?>
            <a href="contact_admin.php">Contact</a>
        </nav>
    </header>

    <script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  var availabledep = [
  "Ain","Aisne","Allier","Alpes-de-Haute-Provence","Hautes-Alpes","Alpes-Maritimes","Ardeche","Ardennes","Ariege","Aube","Aude","Aveyron","Bouches-du-Rhône","Calvados","Cantal","Charente","Charente-Maritime","Cher","Corrèze","Corse","Cote-d Or","Côtes-d Armor","Creuse","Dordogne","Doubs","Drome","Eure","Eure-et-Loir","Finistere","Gard","Haute-Garonne","Gers","Gironde","Herault","Ille-et-Vilaine","Indre","Indre-et-Loire","Isere","Jura","Landes","Loir-et-Cher","Loire","Haute-Loire","Loire-Atlantique","Loiret","Lot","Lot-et-Garonne","Lozere","Maine-et-Loire","Manche","Marne","Haute-Marne","Mayenne","Meurthe-et-Moselle","Meuse","Morbihan","Moselle","Nievre","Nord","Oise","Orne","Pas-de-Calais","Puy-de-Deme","Pyrenees-Atlantiques","Hautes-Pyrenees","Pyrenees-Orientales","Bas-Rhin","Haut-Rhin","Haute-Saone","Saone-et-Loire","Sarthe","Savoie","Haute-Savoie","Paris","Seine-Maritime","Seine-et-Marne","Yvelines","Deux-Sevres","Somme","Tarn","Tarn-et-Garonne","Var","Vaucluse","Vendee","Vienne" ,"Haute-Vienne","Vosges","Yonne","Territoire de Belfort","Essonne","Hauts-de-Seine","Seine-Saint-Denis","Val-de-Marne","Val-d Oise"
  ];
  var availablechoice1 = ["nudiste","non nudiste"];
  var availablechoice2 = ["publique","privée"];
  var availablechoice3 = ["sable","galets"];
  
  $( "#dep" ).autocomplete({
    source: availabledep
  });
  $( "#choice1" ).autocomplete({
    source: availablechoice1
  });
  $( "#choice2" ).autocomplete({
  source: availablechoice2
  });
  $( "#choice3" ).autocomplete({
  source: availablechoice3
  });
  
} );
</script>

    <div id="find-box">
        <div class="center"> 
          <h1 class="finding"> Chercher une plage </h1>
          <form class="finding_beach" action="beach_findA.php" method="post">
          <input type="text" name="city" placeholder="Ville" />
          <input id="dep" type="text" name="departement" placeholder="Département" autocomplete="off" />
          <div id="result"></div>
          <input type="text" name="beach" placeholder="Nom de la Plage" /> 
          <input id="choice3" type="text" name="caracteristics" placeholder="sable/galets" >
          <input id="choice2" type="text" name="privacy" placeholder="publique/privée" >
          <input id="choice1" type="text" name="nudity" placeholder="nudiste/non nudiste" >    
          <input type="submit" name="finding_submit" value="Rechercher" />
          </form>
    </div>
</div>
    
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

</html>
