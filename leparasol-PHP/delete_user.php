<?php session_start();?> 
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Le Parasol</title>
    <link rel="stylesheet" href="app.css">
    <link rel="stylesheet" href="contact.css">
    <link rel="stylesheet" href="compte.css">
    <link rel="stylesheet" href="answer.css">
    <link rel="stylesheet" href="registration.css">
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

 <body>
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
        <a href="index_admin.php">Accueil</a>
        <a href="find_admin.php">Chercher une plage</a>
        <a href="speak_admin.php" class="active">Parler d'une plage</a>
        <a href="compte_admin.php">Mon Compte</a>
        <a href="contact_admin.php">Contact</a>
        </nav>
 </header>

 <?php 
include('includes/dbh.inc.php');

 $sql='SELECT * FROM public."Collaborator"';
    $result = $conn->prepare($sql);
    $result->execute(array());
    ?> <table> <thead> <tr> <th> Nom </th> <th> Prénom </th> <th> Mail </th> </tr> </thead> 
     <colgroup>
    	<col span="1" width="200" style="background-color:#444" />
        <col span="1" width="150" style="background-color: #444" />
        <col span="1" width="150" style="background-color: #444" />
    </colgroup>
    <style type="text/css">
 
td /* Les cellules normales */
{
border:1px solid black;
font-family:'Montserrat', sans-serif;
text-align:center;
color : #fab005; /* Tous les textes des cellules seront centrés*/
padding:5px; /* Petite marge intérieure aux cellules pour éviter que le texte touche les bordures */
}
th
{
border:1px solid black;
font-family: 'Montserrat', sans-serif;
text-align:center;
color : #fab005; /* Tous les textes des cellules seront centrés*/
padding:5px; /* Petite marge intérieure aux cellules pour éviter que le texte touche les bordures */
}

</style>
    <?php
    while ($row=$result->fetch(PDO::FETCH_ASSOC)) {
        ?>
        
        <tr>
            <td> <?php echo $row['lastname'] ; ?> </td>
            <td> <?php echo $row['firstname'] ; ?> </td>
            <td> <?php echo $row['mail'] ?> </td>
        </tr>
    
        <?php }?>
        </table>
     <div id="find-user">
     <div class="center">
     <h1 class="finding"> Supprimer un utilisateur</h1>
     <form class="finding_user" action="deleting_user.php" method="post">
          <input type="text" name="mail" placeholder="Email à supprimer" />
          <input type="text" name="mail_admin" placeholder="Email Administrateur" />
          <input type="password" name="passwd" placeholder="Mot de passe "/>
          <input type="password" name="passwd_admin" placeholder="Mot de passe Admin"/>
          <input type="submit" name="delete" value="Supprimer"/>
          </form>
          </div>
          </div>

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
 

          



