<?php
include('includes/header_admin.php') ;
 /** Préparation et exécution de la requête **/

 include('includes/dbh.inc.php');


 if (isset($_POST['signup_submit'])){
    $forname=$_POST['forname'];
    $name=$_POST['name'];
    $email=$_POST['email_sign'];
    $password_admin=$_POST['passwd_admin'];
    $password=$_POST['password_sign'];
    $password2=$_POST['password2_sign'];

    if (empty($email)|| empty($forname)||empty($name) ||empty($password)||empty($password_admin)) {
        echo '<p>Veuillez remplir tous les champs</p> <p>Cliquez <a href="admin.php">ici</a> 
        pour revenir à la page de connexion administrateur</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion utlisateur</p>';
        exit();
        
    }

    if (strlen($password) <6){
        echo '<p>Le mot de passe est trop court</p> <p>Cliquez <a href="admin.php">ici</a> 
        pour revenir à la page de connexion administrateur</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion</p>';
        exit();
    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>mail invalide</p> <p>Cliquez <a href="admin.php">ici</a> 
        pour revenir à la page de connexion administrateur</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion</p>';
        exit();
    }

    else if($password !==$password2) {
       echo '<p>Veuillez rentrer 2 mots de passes identiques</p> <p>Cliquez <a href="admin.php">ici</a> 
       pour revenir à la page de connexion administrateur</p>  <p>Cliquez <a href="registration.php">ici</a> 
       pour revenir à la page de connexion</p>';
        exit();
    }
    
    else if ($password_admin!== "admin"){
        echo '<p>Veuillez rentrer le bon mot de passe administrateur</p> <p>Cliquez <a href="admin.php">ici</a> 
        pour revenir à la page de connexion administrateur</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion utilisateur</p>';
        exit();
    }

    $sql='SELECT firstname, lastname, mail, passwd FROM public."Administrator";';
    $result = $conn->prepare($sql);
    $result->execute();
    $row = $result->fetch(PDO::FETCH_ASSOC);

    if ($email==$row['mail']){
        echo "Mail deja existant! Veuillez changer de mail ou vous connecter <a href=registration.php>ici</a>";
        exit();
      }

    else{

        

 $sql = 'INSERT INTO public."Administrator"(firstname, lastname, mail, passwd)
	VALUES ( ?, ?, ?, ?);';
 $result = $conn->prepare($sql);
 $result->execute(array($forname,$name,$email, $password));
$data=$result->fetch();
echo '<p>Bienvenue' .$forname.'</p> <p>Cliquez <a href="index_admin.php">ici</a> 
pour revenir à la page d accueil</p>';
$_SESSION['lastname'] = $data['lastname'];
$_SESSION['firstname'] = $forname;

if (isset($_SESSION['lastname']) AND isset($_SESSION['firstname']))
{
    echo 'Bonjour ' . $_SESSION['forname'];
}
else {
  echo "non";
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

