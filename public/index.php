<html>
    <head>
       <meta charset="utf-8">
       <link rel="stylesheet" href="style/style2.css"/>
       <?php
		if(isset($_GET['state'])){
                   $state=$_GET['state'];
                   if ($state==0){
	             session_start();
	             session_destroy();
	           }
	        }
       ?>
    </head>
    <body>
      <div id="header" class="header">
      <img src="style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="accueil.php">Accueil</a>
	 <a href="contact/contact.php">Contact</a>
	 <a href="index.php" class="active">Connexion</a>
         </div>
      </div>
      <div id="container">
	Bienvenue sur <b>T-Oraux</b>&#8239;!
      </div>
      <div id="container">
	<?php
		if(isset($_GET['id'])){
                   $id=$_GET['id'];
                   if ($id==1){
                   echo "<p style='color:green'> Création de compte réussie </p>";}}?>
	<form action="login.php" method="POST">
	<h1>Connexion</h1>
        <label><b>Nom d’utilisateur</b></label>
        <input type="text" placeholder="Nom d’utilisateur" name="username" required>

        <label><b>Mot de passe</b></label>
        <input type="password" placeholder="Mot de passe" name="password" required>

	<div class="bouton">
	<input type="submit" id='submit' value='Se connecter' >
	</div>
	<div class="bouton">
	  <input type="button" id='Rappel' value="Mot de passe oublié&#8239;?"
		 onClick="window.location.href='rappel_mdp/rappel.php'">
	  <?php
	     if(isset($_GET['mdp'])){
             $id=$_GET['mdp'];
             if ($id==2){
             echo "<p style='color:green'> Reponse: </p>";}} ?>
	  <input type="button" id='Rappel' value="Créer compte"
		 onClick="window.location.href='enregistrement/enr1.php'">
          <?php
             if(isset($_GET['erreur'])){
             $err = $_GET['erreur'];
             if($err==1 || $err==2)
             echo "<p style='color:red'>Utilisateur ou mot de passe incorrect!</p>";
             }
             ?>
	  </div>
	</form>
      </div>
  </body>
</html>
