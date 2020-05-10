
<?php

include '../src/User.php';
include '../src/UserRepository.php';
include '../src/Factory/DbAdaperFactory.php';
include '../src/Asso.php';
include '../src/AssoRepository.php';

$dbAdaper = (new DbAdaperFactory())->createService();
$assoRepository = new \Asso\AssoRepository($dbAdaper);

session_start();

$userid=$_SESSION['user']->getId();

$assoAll=$assoRepository->fetch_all_Assos();
?>

    <!DOCTYPE html>
    <html>
    <head>
        <link rel="stylesheet" href="style.css"/>
        <h1> Demande afin de devenir administrateur </h1>
    </head>

    <body>
    <fieldset>
    <legend id="leg1" align="center" > Formulaire </legend> <br />
    <form name="myForm" action="/NewDemande.php" method="post" onsubmit="return validateForm()" >

<!--     Nom <em id="em1">*</em> :
      <input type="text" name="username" value="" id ="username" >  <br />
 -->
    Je souhaite devenir administrateur de : 
    <?php
  echo "<form >";
  echo "<select name='nomasso' size='1'>";
  foreach($assoAll as $element){
    $val=$element->getNomAssoc();
    if($assoRepository->appartient($val,$_SESSION['user']->getId())){
      echo "<option value='$val'>".$val;
      echo "</option>";
    }
  }
  echo "</select>";
  echo ' <input type="submit" name="demande_admin" value="Envoyer la demande" id ="bouton_demande_admin" align="center">';
  echo "</form>";
?>     


    </body> 
    </html>
