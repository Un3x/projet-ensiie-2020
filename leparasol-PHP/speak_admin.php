<?php include('includes/header_admin.php') ;?>


 <?php if (isset($_SESSION['firstname'])) { ?>
        <div class="w3-col w3-animate-opacity"style="width:30% ">
            <button class="w3-button w3-block w3-black" onclick="location.href='speaking_admin.php'">Poster un commentaire</button>
        </div>
      

      <div class="w3-row">

      </div>
        <?php }?>
        <?php if (!isset($_SESSION['firstname'])) {?>

          <div class="w3-col w3-animate-opacity"style="width:30% ">   
          <button class="w3-button w3-block w3-black" onclick="location.href='registration.php'">Se Connecter</button>
        </div>
        <div class="w3-row">
        </div>
        
        <?php }
        include('includes/dbh.inc.php');
$sql='SELECT * FROM public."Commentaire",public."Beach" WHERE name_beach=plage ORDER BY id;';

$result = $conn->prepare($sql);
$result->execute();

if (!($result->fetch(PDO::FETCH_ASSOC))) {
    echo "aucun commentaire posté";
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

</html>
<?php
    exit();
}
else {
    while ($row=$result->fetch(PDO::FETCH_ASSOC)){ ?>
      <div class="row">
<div class="col-sm-4">
<div class="card">
  <style>
.card img {
      width: 10px;
  height: 10px;
    }
  </style>
  <h1><span><?php echo $row['plage']; ?> <br></span></h1>
  <?php echo " Note du commentaire: "; echo round($row['note'],1); ?> </p>
  <a href="delete_comment.php"> <img src="src/img/croix.jpg" alt="delete" title="Supprimer XXX" /></a>
       

  <p> <?php echo $row['nom']; echo " "; echo $row['prenom']; echo ": "; echo $row['commentaire']; echo ' ('; echo $row['id']; echo ') '; ?> <br>
  <?php 
  $rep='SELECT * FROM public."Reponse"  WHERE id=?';
  $reponse = $conn->prepare($rep);
$reponse->execute(array($row['id']));
$reponse2=$reponse->fetch(PDO::FETCH_ASSOC);
while($reponse2){
  echo $reponse2['nom']; echo " "; echo $reponse2['prénom']; echo " a répondu: "; echo $reponse2['réponse']; 
  $reponse2=$reponse->fetch(PDO::FETCH_ASSOC);?></p>
  <?php }
  if (isset($_SESSION['firstname'])) { ?>
  <p><button><?php echo '<a href="answer_admin.php">Répondre</a> '; ?></button></p> <br> <?php }?>
</div>
</div>
</div>
    <?php }}?>
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
                    <a href="#">Conditions d''utilisation</a>
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
    
?>

        
