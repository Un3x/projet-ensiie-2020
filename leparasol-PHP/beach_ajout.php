<?php 
include('includes/header_admin.php') ;
include('includes/dbh.inc.php');


 if (isset($_POST['add_submit'])){
    $city=$_POST['city'];
    $dep=$_POST['departement'];
    $beach=$_POST['beach'];
    $car=$_POST['caracteristics'];
    $privacy=$_POST['privacy'];
    $nudity=$_POST['nudity'];
    $freq=$_POST['frequentation'];
    $des=$_POST['description'];
    $note=$_POST['note'];

    if (empty($city)|| empty($dep)||empty($beach) ||empty($car)||empty($privacy) || empty($nudity)|| empty($freq)|| empty($des)|| empty($note)) {
        echo '<p>Veuillez remplir tous les champs</p> <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
        
    }

    if ($nudity!= 'non nudiste' && $nudity != 'nudiste') {
        echo 'Valeur nudity non valide! Rentrez "nudiste" ou "non nudiste" <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
    }

    if ($car != 'galet' && $car!='sable') {
        echo 'Valeur car non valide!  Rentrez "sable" ou "galet" <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
    }

    if ($privacy != 'publique' && $privacy!='privée') {
        echo 'Valeur privacy non valide!  Rentrez "publique" ou "privée" <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
    }

    if ($freq != 'faible' && $freq!='moyenne' && $freq!='élevée') {
        echo 'Valeur freq non valide!  Rentrez "fraible" ou "élevée" ou "moyenne" <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
    }
    $all_dep=array('Ain','Aisne','Allier','Alpes-de-Haute-Provence','Hautes-Alpes','Alpes-Maritimes','Ardeche','Ardennes','Ariège','Aube'
    ,'Aude','Aveyron','Bouches-du-Rhône','Calvados','Cantal','Charente','Charente-Maritime','Cher'
    ,'Correze','Corse','Cote-d Or', 'Cotes-d Armor','Creuse','Dordogne', 'Doubs', 'Drome','Eure'
    ,'Eure-et-Loir','Finistere','Gard', 'Haute-Garonne','Gers','Gironde','Herault','Ille-et-Vilaine','Indre','Indre-et-Loire'
   ,'Isere','Jura','Landes','Loir-et-Cher','Loire','Haute-Loire','Loire-Atlantique','Loiret','Lot', 'Lot-et-Garonne'
   ,'Lozere','Maine-et-Loire','Manche','Marne','Haute-Marne','Mayenne','Meurthe-et-Moselle','Meuse','Morbihan','Moselle','Nievre'
     ,'Nord','Oise','Orne','Pas-de-Calais','Puy-de-Dome','Pyrenees-Atlantiques','Hautes-Pyrenees','Pyrenees-Orientales','Bas-Rhin','Haut-Rhin'
     ,'Rhone','Haute-Saone','Saone-et-Loire','Sarthe','Savoie','Haute-Savoie','Paris','Seine-Maritime','Seine-et-Marne','Yvelines','Deux-Sevres'
    ,'Somme','Tarn','Tarn-et-Garonne','Var','Vaucluse','Vendee','Vienne','Haute-Vienne','Vosges','Yonne','Territoire de Belfort','Essonne','Hauts-de-Seine','Seine-Saint-Denis'
    ,'Val-de-Marne','Val-d Oise');

    if (!(in_array($dep,$all_dep))) {
        echo 'rentrez un département valide. <p>Cliquez <a href="ajout.php">ici</a> 
        pour revenir à la page d ajout de plage </p>';
        exit();
    }
    
    else {
        $sql='INSERT INTO public."Beach" (departement, localisation, name_beach, caracteristics, nudity, frequentation, privacy, description, note) VALUES (?,?,?,?,?,?,?,?,?);';
        $sql_city='INSERT INTO public."City"(e
            name_city, departement)
            VALUES (?, ?);';
        $result = $conn->prepare($sql);
        $result_city=$conn->prepare($sql_city);
        $result->execute(array($dep,$city,$beach,$car,$nudity,$freq,$privacy,$des,$note));
        $result_city->execute(array($city,$dep));
        if ($result && $result_city){
            echo 'La plage a bien été ajoutée!';
            ?>

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

</body> <?php
            exit();
        }
        else {
            echo 'non ajoute';
            exit();
        }
    }
}
?>

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