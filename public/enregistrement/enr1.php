<html>
  <head>
    <meta charset="utf-8">
    <link rel="stylesheet" href="../style/style2.css"/>
  </head>
  <body>
    <div id="header" class="header">
      <?php
         session_start();
         if(isset($_SESSION['username'])){
         $user = $_SESSION['username'];
         echo "<div style='position:relative; top:0px; right:0px; text-align:right;'>Bonjour $user, vous êtes connecté</div>";
	 }
         ?>
       <img src="../style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="../accueil.php">Accueil</a>
	 <?php
	 if(isset($_SESSION['username'])){   
	    $link_profil="profil.php?id=".$user."";
	    echo "<a href='".$link_profil."'>Mon profil</a>";
	 }
	 ?>
	 <a href="../contact/contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=../index.php?state=0>Déconnexion</a>";
	 }
	 else{
	    echo "<a href=../index.php>Connexion</a>";
	 }
	 ?>
         </div>
        </div>
    <div id="container">            
      <form action="enr2.php" method="POST"  enctype="multipart/form-data">
        <h1>Créer compte</h1>
	
        <label><b>Nom d'utilisateur</b></label>
        <input type="text" placeholder="Nom d’utilisateur" name="username"  required>
	

		</br>
                <label><b>Mot de passe&nbsp;</b></label>
                <input type="password" placeholder="Mot de passe" name="password" required>
		
		</br>
		<label><b>Répétez votre mot de passe&nbsp;</b></label>
                <input type="password" placeholder="Mot de passe" name="password2" required>
		
		</br>
		</br>
		<label><b>Question secrète&nbsp;:</b></label>
                <select id="Question" name="question" required>
   		  <option value="Animal préféré">Animal préféré ?</option>
		  <option value="Prénom de votre mère">Prénom de votre Mère ?</option>
		  <option value="Poste Entreprise">Poste en Entreprise ?</option>
		  <option value="Film favori">Film favori ?</option>
  		</select>
		<br>
		</br>
		<label><b>Réponse à la question secrète&nbsp;</b></label>
                <input type="text" placeholder="Réponse" name="answer" required>

		<label><b>Filière&nbsp;:</b></label>
                <select id="fil" name="filière" required>
   		  <option value="MPSI">MPSI</option>
		  <option value="MP">MP</option>
		  <option value="PCSI">PCSI</option>
		  <option value="PC">PC</option>
		  <option value="PSI">PSI</option>
		  <option value="ATS">ATS</option>
		  <option value="PT">PT</option>
  		</select>
		</br>
		
		<label for="email"><b>Email&nbsp;:</b></label>
		<input type="email" id="email" name="email"/>
		</br>

		<label for="Photo">Image personnelle&nbsp;:</label>
		<input type="file" name="photo" id="Photo">
		</br>
		
                <input type="submit" id='submit' value='Enregistrer' >
                <?php
                  if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
		     echo "<p style='color:red'> erreur $err </p>";
                    if($err==1)
                    echo "<p style='color:red'> Mots de passe non identiques </p>";
                    if($err==2)
                    echo "<p style='color:red'> Utilisateur déjà existant </p>"; 
                    if($err==3)
                    echo "<p style='color:red'> Question non choisie  </p>";
                    if($err==4)
                    echo "<p style='color:red'> Mauvaise extension de fichier  </p>";
                    if($err==5)
                    echo "<p style='color:red'> Fichier trop lourd  </p>";}
                 ?>
		
	    </form>
        </div>
    </body>
</html>
