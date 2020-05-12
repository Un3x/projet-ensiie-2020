<?php
 /** Préparation et exécution de la requête **/
include('includes/header.php');
 include('includes/dbh.inc.php');
 ?><link rel="stylesheet" href="test.css">
<?php 
if (isset($_POST['finding_submit'])){
    $city=$_POST['city'];
    $dep=$_POST['departement'];
    $beach=$_POST['beach'];
    $car=$_POST['caracteristics'];
    $privacy=$_POST['privacy'];
    $nudity=$_POST['nudity'];

    if (!(empty($nudity)) && $nudity!= 'non nudiste' && $nudity != 'nudiste') {
        echo 'Valeur nudity non valide! Rentrez "nudiste" ou "non nudiste" <p>Cliquez <a href="find.php">ici</a> 
        pour revenir à la page de recherche de plage </p>';
        exit();
    }

    if ($car != 'galet' && $car!='sable'&&!(empty($car))) {
        echo 'Valeur car non valide!  Rentrez "sable" ou "galet" <p>Cliquez <a href="find.php">ici</a> 
        pour revenir à la page de recherche de plage </p>';
        exit();
    }

    if ($privacy != 'publique' && $privacy!='privée'&&!(empty($privacy))) {
        echo 'Valeur privacy non valide!  Rentrez "publique" ou "privée" <p>Cliquez <a href="find.php">ici</a> 
        pour revenir à la page de recherche de plage </p>';
        exit();
    }

    $all_dep=array('Ain','Aisne','Allier','Alpes-de-Haute-Provence','Hautes-Alpes','Alpes-Maritimes','Ardeche','Ardennes','Ariege','Aube'
    ,'Aude','Aveyron','Bouches-du-Rhône','Calvados','Cantal','Charente','Charente-Maritime','Cher'
    ,'Correze','Corse','Cote-d Or', 'Cotes-d Armor','Creuse','Dordogne', 'Doubs', 'Drome','Eure'
    ,'Eure-et-Loir','Finistere','Gard', 'Haute-Garonne','Gers','Gironde','Herault','Ille-et-Vilaine','Indre','Indre-et-Loire'
   ,'Isere','Jura','Landes','Loir-et-Cher','Loire','Haute-Loire','Loire-Atlantique','Loiret','Lot', 'Lot-et-Garonne'
   ,'Lozere','Maine-et-Loire','Manche','Marne','Haute-Marne','Mayenne','Meurthe-et-Moselle','Meuse','Morbihan','Moselle','Nievre'
     ,'Nord','Oise','Orne','Pas-de-Calais','Puy-de-Dome','Pyrenees-Atlantiques','Hautes-Pyrenees','Pyrenees-Orientales','Bas-Rhin','Haut-Rhin'
     ,'Rhone','Haute-Saone','Saone-et-Loire','Sarthe','Savoie','Haute-Savoie','Paris','Seine-Maritime','Seine-et-Marne','Yvelines','Deux-Sevres'
    ,'Somme','Tarn','Tarn-et-Garonne','Var','Vaucluse','Vendee','Vienne','Haute-Vienne','Vosges','Yonne','Territoire de Belfort','Essone','Hauts-de-Seine','Seine-Saint-Denis'
    ,'Val-de-Marne','Val-d Oise');

    if (!(in_array($dep,$all_dep))&&!(empty($dep))) {
        echo 'rentrez un département valide. <p>Cliquez <a href="find.php">ici</a> 
        pour revenir à la page de recherche de plage </p>';
        exit();
    }
    if(!empty($city) && empty($dep)&& empty($beach) && empty($car) && empty($privacy) && empty($nudity)) {
        $sql='SELECT * FROM public."Beach" WHERE localisation=? ORDER BY note DESC';
        $result = $conn->prepare($sql);
        $result->execute(array($city));
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
            exit();
        }
        $result->execute(array($city));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
          <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation'];  ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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

<?php
        
        exit();
        }?>
        <?php

    if(!empty($dep)&& empty($city)&& empty($beach) && empty($car) && empty($privacy) && empty($nudity)) {
            $sql='SELECT * FROM public."Beach" WHERE departement=? ORDER BY note DESC';
            $result = $conn->prepare($sql);
            $result->execute(array($dep));
         
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
            exit();
        }
        $result->execute(array($dep));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
          <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
<?php
        exit();
        }
            if(empty($beach)&& empty($city)&& empty($dep) && empty($car) && empty($privacy) && empty($nudity)) {
                $sql='SELECT * FROM public."Beach" ORDER BY note DESC';
                $result = $conn->prepare($sql);
                $result->execute();
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
            exit();
        }
        $result->execute(array());
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){ ?>

<main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
     <?php if (empty($_SESSION['firstname'])){?>
     <a href="registration.php" class="cart-btn">Poster un commentaire</a> 
     <?php } else {
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
                
                <?php
                        
                        exit();
                        
                      }
    if(!empty($beach)&& empty($city)&& empty($dep) && empty($car) && empty($privacy) && empty($nudity)) {
                $sql='SELECT * FROM public."Beach" WHERE name_beach=? ORDER BY note DESC';
                $result = $conn->prepare($sql);
                $result->execute(array($beach));
           
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
            exit();
        }
        $result->execute(array($beach));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                
                <?php
                        
                        exit();
                        }

    if(!empty($car)&& empty($city)&& empty($beach) && empty($dep) && empty($privacy) && empty($nudity)) {
                    $sql='SELECT * FROM public."Beach" WHERE caracteristics=? ORDER BY note DESC';
                    $result = $conn->prepare($sql);
                    $result->execute(array($car));
                    
                       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
                           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
                           exit();
                       }
                       $result->execute(array($car));
                       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
<main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                
                <?php
                        
                        exit();
                        }
    if(!empty($privacy) && empty($city)&& empty($beach) && empty($car) && empty($dep) && empty($nudity)) {
                        $sql='SELECT * FROM public."Beach" WHERE privacy=? ORDER BY note DESC';
                        $result = $conn->prepare($sql);
                        $result->execute(array($privacy));
                       
                           if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
                               echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
                               exit();
                           }
                           $result->execute(array($privacy));
                           while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
                             <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                            
                            <?php
                                    
                                    exit();
                                    }

    if(!empty($nudity)&& empty($city)&& empty($beach) && empty($car) && empty($privacy) && empty($dep)) {
                   $sql='SELECT * FROM public."Beach" WHERE nudity=? ORDER BY note DESC';
                            $result = $conn->prepare($sql);
                            $result->execute(array($nudity));
                           
                               if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
                                   echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
                                   exit();
                               }
                               $result->execute(array($nudity));
                               while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
                                <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                                
                                <?php
                                        
                                        exit();
                                        }       
                            
if (!(empty($dep)) && !(empty($city)) && empty($beach) && empty($car) && empty($privacy) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE departement=? AND localisation=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($dep,$city));
    
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($dep,$city));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                
                <?php
                        
                        exit();
                        }
}
if (!(empty($beach)) && !(empty($city)) && empty($dep) && empty($car) && empty($privacy) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE name_beach=? AND localisation=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($beach,$city));
    
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($beach,$city));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
        <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
                
                <?php
                        
                        exit();
                        }


if (!(empty($car)) && !(empty($city))&& empty($beach) && empty($dep) && empty($privacy) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE caracteristics=? AND localisation=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($car,$city));
    
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($car,$city));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
        <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }
if (!(empty($privacy)) && !(empty($city))&& empty($beach) && empty($car) && empty($dep) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE privacy=? AND localisation=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($privacy,$city));
  
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($privacy,$city));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
        <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }


if (!(empty($nudity)) && !(empty($city))&& empty($beach) && empty($car) && empty($privacy) && empty($dep)){
    $sql='SELECT * FROM public."Beach" WHERE nudity=? AND localisation=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($nudity,$city));
    
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($nudity,$city));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }


if (!(empty($dep)) && !(empty($nudity))&& empty($beach) && empty($car) && empty($privacy) && empty($city)){
    $sql='SELECT * FROM public."Beach" WHERE departement=? AND nudity=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($dep,$nudity));
  
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($dep,$nudity));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }


if (!(empty($dep)) && !(empty($privacy))&& empty($beach) && empty($car) && empty($city) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE departement=? AND privacy=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($dep,$privacy));
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($dep,$privacy));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
       <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }

if (!(empty($dep)) && !(empty($car))&& empty($beach) && empty($city) && empty($privacy) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE departement=? AND caracteristics=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($dep,$car));
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($dep,$car));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }

if (!(empty($dep)) && !(empty($beach))&& empty($city) && empty($car) && empty($privacy) && empty($nudity)){
    $sql='SELECT * FROM public."Beach" WHERE departement=? AND name_beach=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($dep,$beach));
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
            exit();
        }
        $result->execute(array($dep,$beach));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                
                exit();
                }

if (!(empty($city)) && !(empty($nudity)) &&!(empty($privacy)) && !(empty($car)) && empty($dep) &&empty($beach)) {
    $sql='SELECT * FROM public."Beach" WHERE localisation=? AND caracteristics=? AND privacy=? AND nudity=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($city,$car,$privacy,$nudity));
    
       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($city,$car,$privacy,$nudity));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span><?php echo round($row['note'],1); echo "/5"; ?></span>
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
        
        <?php
                exit();
                }

if (!(empty($city)) && !(empty($nudity)) &&!(empty($privacy)) && !(empty($car)) && !(empty($dep)) &&empty($beach)) {
    $sql='SELECT * FROM public."Beach" WHERE localisation=? AND caracteristics=? AND privacy=? AND nudity=? and departement=? ORDER BY note DESC';
    $result = $conn->prepare($sql);
    $result->execute(array($city,$car,$privacy,$nudity,$dep));

       if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
           echo "<p>Aucune plage correspondante! N hésitez pas à  nous contacter si vous souhaitez que l on ajoute une plage en cliquant <a href=\"contact.php\" > ici </a> </p>";
           exit();
       }
       $result->execute(array($city,$car,$privacy,$nudity,$dep));
       while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
        <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ; echo ","; echo $row['localisation']; ?> </span>
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
     <span></span>
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
        
        <?php
                exit();
                }
?>
