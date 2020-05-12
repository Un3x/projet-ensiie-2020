<?php session_start();?>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Parasol</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="beach_find.css">
    <link rel="stylesheet" href="registration.css">
    <link rel="stylesheet" href="answer.css">
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
        <a href="index.php">Accueil</a>
        <a href="find.php">Chercher une plage</a>
        <a href="speak.php" class="active">Parler d'une plage</a>
        <a href="compte.php">Mon Compte</a>          
        <a href="contact.php">Contact</a>
    </nav>
</header>
<?php

 /** Préparation et exécution de la requête **/

 include('includes/dbh.inc.php');


 if (isset($_POST['signup_submit'])){
    $forname=$_POST['forname'];
    $name=$_POST['name'];
    $email=$_POST['email_sign'];
    $password=$_POST['password_sign'];
    $password2=$_POST['password2_sign'];

    $header="MIME-Version: 1.0\r\n";
$header.='From:"PrimFX.com"<support@primfx.com>'."\n";
$header.='Content-Type:text/html; charset="uft-8"'."\n";
$header.='Content-Transfer-Encoding: 8bit';

$message='
<html>
	<body>
		<div align="center">
			<img src="http://www.primfx.com/mailing/banniere.png"/>
			<br />
			J\'ai envoyé ce mail avec PHP !
			<br />
			<img src="http://www.primfx.com/mailing/separation.png"/>
		</div>
	</body>
</html>
';

    if (empty($email)|| empty($forname)||empty($name) ||empty($password)) {
        echo '<p>Veuillez remplir tous les champs</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion</p>';
        exit();
        
    }
    
    if (strlen($password) <6){
        echo '<p>Le mot de passe est trop court</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion</p>';
        exit();
    }

    else if(!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        echo '<p>mail invalide</p> <p>Cliquez <a href="registration.php">ici</a> 
        pour revenir à la page de connexion</p>';
        exit();
    }

    else if($password !==$password2) {
       echo '<p>Veuillez rentrer 2 mots de passes identiques</p> <p>Cliquez <a href="registration.php">ici</a> 
       pour revenir à la page de connexion</p>';
        exit();
    }

    $sql='SELECT firstname, lastname, mail, passwd FROM public."Collaborator" WHERE mail=?;';
    $result = $conn->prepare($sql);
    $result->execute(array($email));

    while ($row = $result->fetch(PDO::FETCH_ASSOC)) {
    if ($_POST['email_sign']==$row['mail']){
        echo 'Ce mail est déja utilisé! Veuillez changer ou vous <a href="registration.php">connecter</a> ';
        exit();
      }
    }

 $sql = 'INSERT INTO public."Collaborator"(firstname, lastname, mail, passwd)
	VALUES ( ?, ?, ?, ?);';
 $result = $conn->prepare($sql);
 $result->execute(array($forname,$name,$email, $password));
$data=$result->fetch(PDO::FETCH_ASSOC);

$_SESSION['firstname'] = $forname;
$_SESSION['lastname']=$name;
mail($email, "Bienvenue!", $message, $header);
if( isset($_SESSION['firstname']))
{
    echo 'Bienvenue ' . $_SESSION['firstname'];
    
}
echo '</p> <p>Cliquez <a href="index.php">ici</a> 
pour revenir à la page d accueil</p>';
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

