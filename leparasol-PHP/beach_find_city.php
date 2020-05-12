<?php include('includes/header.php');?>
<?php
 /** Préparation et exécution de la requête **/

 include('includes/dbh.inc.php');
 ?><link rel="stylesheet" href="test.css"> <?php
if (isset($_POST['city_click'])){
    $city=$_POST['departement'];
    
    if (empty($city)) {
        $sql='SELECT * FROM public."Beach" ORDER BY note DESC';
        $result = $conn->prepare($sql);
        $result->execute();
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
            <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ?> </span>
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
       <?php $sql1='SELECT * FROM public."Commentaire" WHERE plage=? ';
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
     <a href="speaking.php" class="cart-btn">Poster un commentaire</a>
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
    
    </body><?php
        exit();
    }
  }

    if(!empty($city)){
        $sql='SELECT * from public."Beach" WHERE localisation=? ORDER BY note DESC';
        $result = $conn->prepare($sql);
        $result->execute(array($city));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)){?>
         <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span><?php echo $row['departement'] ?> </span>
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
       <?php $sql1='SELECT * FROM public."Commentaire" WHERE plage=? ';
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
     <a href="speaking.php" class="cart-btn">Poster un commentaire</a>
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
    
    </body><?php
        exit();

    }
  

