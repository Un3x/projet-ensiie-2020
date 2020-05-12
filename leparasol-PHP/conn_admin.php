<?php
include('includes/header_admin.php') ;
include('includes/dbh.inc.php');

if (isset ($_POST['login_submit'])){
    $mail=$_POST['email'];
    $password=$_POST['password'];

    if (empty($password)) {
        echo '<p>Veuillez rentrer votre mot de passe.</p>
        <p>Cliquez <a href="registration.php">ici</a> pour revenir</p>';
        exit();
    }
    if (empty($mail)) {
        echo '<p>Veuillez rentrer votre adresse.</p>
        <p>Cliquez <a href="registration.php">ici</a> pour revenir</p>';
        exit();
    }

    else {
        $sql='SELECT * FROM public."Administrator" WHERE mail=?;';
        $result = $conn->prepare($sql);
        $result->execute(array($mail));
        while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
             if($_POST['password']== $row['passwd']){
              $_SESSION['firstname'] = $row['firstname'];
              $_SESSION['lastname']=$row['lastname'];
              echo "Bonjour";
              echo " ";
              echo $_SESSION['firstname'];
 
              
          }
          else{
         echo '<p> Une erreur est produite</p> <p>Cliquez <a href="admin.php">ici</a> 
			pour revenir à la page de connexion</p>';
        }
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

