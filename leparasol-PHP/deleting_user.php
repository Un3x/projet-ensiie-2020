<?php include('includes/header_admin.php') ;?>

<?php
 /** Préparation et exécution de la requête **/

 include('includes/dbh.inc.php');

if (isset($_POST['delete'])){
    $mail=$_POST['mail'];
    $mail_admin=$_POST['mail_admin'];
    $passwd=$_POST['passwd'];
    $passwd_admin=$_POST['passwd_admin'];

    if(empty($mail)|| empty($passwd)||empty($passwd_admin)||empty($mail_admin)){
        echo 'Veuillez rentrer tous les champs! <p> Cliquez <a href="delete_user.php">ici</a> pour revenir en arrière.';
        exit();
    }

    else {
        $sql='SELECT * FROM public."Collaborator" WHERE mail=?';
        $result = $conn->prepare($sql);
        $result->execute(array($mail));
        if (!($row=$result->fetch(PDO::FETCH_ASSOC))) {
            echo "aucun mail correspondant!";
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

        $sql2='SELECT * FROM public."Administrator" WHERE mail=?;';
        $result2=$conn->prepare($sql2);
        $result2->execute(array($mail_admin));
        if (!($row2=$result2->fetch(PDO::FETCH_ASSOC))) {
            echo "aucun mail admin correspondant!";
            ?><footer class="footer">
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

        $result2->execute(array($mail_admin));
        if ($passwd_admin!= 'admin'){
            echo "mauvais mot de passe admin";
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

        if ($passwd != $row2['passwd']){
            echo "mauvais mot de passe perso!";
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
        $sql3='DELETE FROM public."Collaborator" WHERE mail=?';
        $result3 = $conn->prepare($sql3);
        $result3->execute(array($mail));
                
        while ($row3 = $result->fetch(PDO::FETCH_ASSOC)){
             echo " delete ";
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
