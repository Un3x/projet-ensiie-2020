<?php 
include ('includes/dbh.inc.php');
include ('includes/header.php');
?><link rel="stylesheet" href="test.css"><?php
$nom=$_SESSION['lastname'];
$pre= $_SESSION['firstname'];

$sql ='SELECT * FROM public."Commentaire" WHERE nom=? and prenom=?';
$result = $conn->prepare($sql);
$result->execute(array($nom, $pre));
$nombre=0;
while(($row = $result->fetch(PDO::FETCH_ASSOC))){ ?>
     <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span> </span>
     <h1>Commentaires</h1>
     <p><?php echo $row['plage'] ?></p>
     <p><?php echo "Note donnée:" ;echo round($row['Note'],1) ?></p>
     <p><?php echo $row['commentaire'] ?></p>
   </div>
   </div>
   </main>

<?php 
$nombre=$nombre+1;
}?>
 <?php echo "Commentaires postés:"; echo $nombre; ?>  

<?php $nombre=0; ?>  
<?php
$nom=$_SESSION['lastname'];
$pre= $_SESSION['firstname'];
$sql1 ='SELECT * FROM public."Reponse" Where nom=? AND prénom=?';
$result1 = $conn->prepare($sql1);
$result1->execute(array($nom,$pre));
while(($row1= $result1->fetch(PDO::FETCH_ASSOC))){ ?>
  <main class="a">
 
 
 
 <!-- Right Column -->
 <div class="right-column">

   <!-- Product Description -->
   <div class="product-description">
     <span> </span>
     <h1>Réponses Postées</h1>
     <p><?php echo $row1['réponse'] ?>.</p>
   </div>
</div>


</main>
<?php 
$nombre=$nombre+1;
}?>
<?php echo "Réponses postées:"; echo $nombre; ?>  
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
        