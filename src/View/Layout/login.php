<?php
$token = md5(rand(0,99999999));
$_SESSION['post.token']=$token;

?>

<!-- 
Cette page permet à l'utilisateur de se connecter, 
il faudra peut être changer la maniere dont l'utilisateur se login (ajout de mdp par exemple).
Ce fichier envoie ses infos à loginUser.php

!! Si l'utilisateur est déjà connecté, cette page ne devrait pas être accessible !!
pour faire ça: check si les attributs de SESSION sont défini (fonction isset()) ^^ 
-->
<?php
  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($fullUrl,"signup=success")){
    echo '<p>Compte créé avec succés!</p></br>';
  }
?>
<p> Inserez vos identifiants: </p>
<form name= "formLoginUser" action="Forms/loginUser.php" onsubmit="return validationFormulaireLogin();" method="POST">
<label for="username"> Nom du compte ou email :</label></br>
    <?php
      if (isset($_GET['username']))
      {
          $username=$_GET['username'];
          echo '<input type="text" name="username" placeholder="username or email adress" maxlength="20"  value="'.$username.'"></br>';
      }
      else 
      {
          echo '<input type="text" name="username" placeholder="username or email adress" maxlength="20" ></br>';
          $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";

          if (strpos($fullUrl, "errs=noUsername"))
          {
              echo "<p>ERROR, no username given</p></br>";
              }
          elseif (strpos($fullUrl, "login=userUnknown"))
          {
              echo "<p>ERROR, username is unknown</p></br>";
          } 
      }
    ?>
<!--
<label for="email">votre adresse mail:</label></br>
-->
    <?php
    /*
      if (isset($_GET['email'])){
          $email=$_GET['email'];
          echo '<input type="text" name="email" placeholder="email adress" maxlength="50" value="'.$email.'"></br>';
      }
      else {
          $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
          echo '<input type="text" name="email" placeholder="email adress" maxlength="50" ></br>';
          if (strpos($fullUrl, "errs=invalidEmail")){
              echo "<p>ERROR, invalid email adress</p></br>";
          }
          elseif (strpos($fullUrl, "login=emailUnknown")){
              echo "<p>ERROR, email is unknown</p></br>";
          }
      }
    */
    ?> 

<label for="password">votre mot de passe:</label></br>
    <input type="password" name="password" placeholder="your password" minlength="8"></br>
    <?php
      $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
      if (strpos($fullUrl, "errs=noPsw")){
        echo "<p>ERROR, no password given</p></br>";
      }
    ?>

<input type="hidden" id="post.token" name="post.token" value="{$token}" /> 
<button type="submit">Se connecter</button>

<?php
  $fullUrl= "http;//$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
  if (strpos($fullUrl, "login=failed"))
  {
    echo "<p> password and username do not match! Try again </p>";
  }
  if (isset($_SESSION['username']))
  {
    $userSession=$_SESSION['username'];
    echo "<p>you are logged as $userSession</p>";
  }
?>
</br>
<a href="registration.php">Se créer un compte</a>

<script type="text/javascript" src="scripts/formulaire.js"></script>
