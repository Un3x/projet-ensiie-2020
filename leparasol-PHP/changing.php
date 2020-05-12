<?php include('includes/header.php');?>

 <?php
 /** Préparation et exécution de la requête **/

 include('includes/dbh.inc.php');

if (isset($_POST['valide'])){
    $mail=$_POST['mail'];
    $oldmdp=$_POST['oldmdp'];
    $newmpd=$_POST['newmdp'];
    $newmpd2=$_POST['newmdp2'];

    if (empty($mail)||empty($oldmdp)||empty($newmpd)||empty($newmpd2)){
        echo "veuillez tout rentrer";
        exit();
    }

    if($newmpd!=$newmpd2){
        echo "rentrez 2 mdp identiques";
        exit();
    }

    else{

        $sql1='SELECT passwd FROM public."Collaborator" WHERE mail=?;';
        $result1 = $conn->prepare($sql1);
        $result1->execute(array($mail));
        $row1=$result1->fetch(PDO::FETCH_ASSOC);
        if ($row1['passwd']!=$oldmdp){
            echo "ancien mot d passe invalide";
            exit();
        }

        $sql='UPDATE public."Collaborator"  SET  passwd=? WHERE mail=?';
        $result = $conn->prepare($sql);
        $result->execute(array($newmpd,$mail));
        if ($result) {
            echo "bien modifie!";
        }

            ?> <footer class="footer">
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
        }
    }
?>
        
