<html>
    <head>
       <meta charset="utf-8">
       <link rel="stylesheet" href="../style/style2.css"/>
    </head>
    <body>
      <div class="header">
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
	    $link_profil="../profil.php?id=".$user."";
	    echo "<a href='".$link_profil."'>Mon Profil</a>";
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
            <form action="uploadsujet.php" method="post" enctype="multipart/form-data">
		<b>Choisissez le sujet:</b>
		<input type="file" name="sujet" id="sujet">
		</br>
		</br>
                <b>Détails sur le sujet :</b>
		</br>
		</br>
                <label><b>Matière:</b></label>
                <select id="Matière" name="Matière" onclick="myFunction()">
   			<option value="Maths">Mathématiques</option>
			<option value="PC">Physique-Chimie</option>
			<option value="Info">Informatique</option>
    	        	<option value="SI">SI</option>
  		</select>
		
		<br>
		
                <label><b>Filière:</b></label><br/>
                <input type="radio" id="MPSI" name="filiere[]" value="MPSI" required>
  		<label for="MPSI">MPSI</label><br>
		
  		<input type="radio" id="MP" name="filiere[]" value="MP">
  		<label for="MP"> MP</label><br>
		
  		<input type="radio" id="PCSI" name="filiere[]" value="PCSI">
  		<label for="PCSI">PCSI</label><br>
		
		<input type="radio" id="PC" name="filiere[]" value="PC">
  		<label for="PC">PC</label><br>
		
		<input type="radio" id="TSI" name="filiere[]" value="TSI">
  		<label for="TSI">TSI</label><br>

		<input type="radio" id="PSI" name="filiere[]" value="PSI">
  		<label for="PSI">PSI</label><br>

		<input type="radio" id="BCPST" name="filiere[]" value="BCPST">
  		<label for="BCPST">BCPST</label><br>

		<input type="radio" id="ATS" name="filiere[]" value="ATS">
  		<label for="ATS">ATS</label><br>

		<br>
			
                <label><b>Année:</b></label>
		<?php $years = range(1990, strftime("%Y", time())); ?>
		<select id="annee" name="annee">
		  <?php foreach($years as $year) : ?>
		  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		  <?php endforeach; ?>
		</select>

		<br>

		
                <label><b>Concours:</b></label><br/>
                <input type="radio" id="CCP" name="concours[]" value="CCP" required>
  		<label for="CCP">CCP</label><br>
		
  		<input type="radio" id="MT" name="concours[]" value="MT">
  		<label for="MT"> Mines-Télécom</label><br>
		
  		<input type="radio" id="EIVPTPE" name="concours[]" value="EIVPTPE">
  		<label for="EIVPTPE">EIVP-TPE</label><br>
		
		<input type="radio" id="X" name="concours[]" value="X">
  		<label for="X">X</label><br>
		
		<input type="radio" id="E3A" name="concours[]" value="E3A">
  		<label for="E3A">E3A</label><br>

		<input type="radio" id="CENTRALE" name="concours[]" value="CENTRALE">
  		<label for="CENTRALE">Centrale-Supéléc</label><br>

		<input type="radio" id="ARTSETMETIERS" name="concours[]" value="ARTSETMETIERS">
  		<label for="ARTSETMETIERS">Arts et Métiers</label><br>


		
		<label><b>Thèmes:</b></label><br/>
                <input type="radio" id="Algèbre" name="themeM[]" value="Algèbre" style="display: none">
  		<label for="Algèbre" name="themeM[]" style="display: none">Algèbre</label>
		<br name="themeM[]" style="display: none">
		
		<input type="radio" id="Topologie" name="themeM[]" value="Topologie" style="display: none">
  		<label for="Topologie" name="themeM[]" style="display: none">Topologie</label>
		<br name="themeM[]" style="display: none">
		
		<input type="radio" id="Fonction et intégration" name="themeM[]" value="Fonction et intégration" style="display: none">
  		<label for="Fonction et intégration" name="themeM[]" style="display: none">Fonction et intégration</label>
		<br name="themeM[]" style="display: none">
		
		<input type="radio" id="Séries" name="themeM[]" value="Séries" style="display: none">
  		<label for="Séries" name="themeM[]" style="display: none">Séries</label>
		<br name="themeM[]" style="display: none">

		<input type="radio" id="Calcul différentiel" name="themeM[]" value="Calcul différentiel" style="display: none">
  		<label for="Calcul différentiel" name="themeM[]" style="display: none">Calcul différentiel</label>
		<br name="themeM[]" style="display: none">

		<input type="radio" id="Probabilités" name="themeM[]" value="Probabilités" style="display: none">
  		<label for="Probabilités" name="themeM[]" style="display: none">Probabilités</label>
		<br name="themeM[]" style="display: none">
		
  		<input type="radio" id="Mécanique" name="themeP[]" value="Mécanique" style="display: none">
  		<label for="Mécanique" name="themeP[]" style="display: none">Mécanique</label>
		<br name="themeP[]" style="display: none">
		
		<input type="radio" id="Optique" name="themeP[]" value="Optique" style="display: none">
  		<label for="Optique" name="themeP[]" style="display: none">Optique</label>
		<br name="themeP[]" style="display: none">
		
		<input type="radio" id="Electromagnétisme" name="themeP[]" value="Electromagnétisme" style="display: none">
  		<label for="Electromagnétisme" name="themeP[]" style="display: none">Electromagnétisme</label>
		<br name="themeP[]" style="display: none">
		
		<input type="radio" id="Electronique" name="themeP[]" value="Electronique" style="display: none">
  		<label for="Electronique" name="themeP[]" style="display: none">Electronique</label>
		<br name="themeP[]" style="display: none">

		<input type="radio" id="Thermodynamique" name="themeP[]" value="Thermodynamique" style="display: none">
  		<label for="Thermodynamique" name="themeP[]" style="display: none">Thermodynamique</label>
		<br name="themeP[]" style="display: none">

		<input type="radio" id="Physique des ondes" name="themeP[]" value="Physique des ondes" style="display: none">
  		<label for="Physique des ondes" name="themeP[]" style="display: none">Physique des ondes</label>
		<br name="themeP[]" style="display: none">

		<input type="radio" id="Cinétique chimique" name="themeP[]" value="Cinétique chimique" style="display: none">
  		<label for="Cinétique chimique" name="themeP[]" style="display: none">Cinétique chimique</label>
		<br name="themeP[]" style="display: none">

		<input type="radio" id="Structure de la matière" name="themeP[]" value="Structure de la matière" style="display: none">
  		<label for="Structure de la matière" name="themeP[]" style="display: none">Structure de la matière</label>
		<br name="themeP[]" style="display: none">

		<input type="radio" id="Graphes" name="themeI[]" value="Graphes" style="display: none">
  		<label for="Graphes" name="themeI[]" style="display: none">Graphes</label>
		<br name="themeI[]" style="display: none">
		
		<input type="radio" id="Arbres" name="themeI[]" value="Arbres" style="display: none">
  		<label for="Arbres" name="themeI[]" style="display: none">Arbres</label>
		<br name="themeI[]" style="display: none">

		
		<input type="submit" id="Envoyer" value="Envoyer" name="Envoyer">


		
	    <p id="containe"></p>

                <?php     
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1){
                   echo "<p style='color:red'>La taille du fichier ne peut pas dépasser 2Mo. </p>";
		   }
		    if($err==2){
                   echo "<p style='color:red'>Choisissez un fichier de type : pdf, jpeg, png, odt. </p>";
		   }
		   if($err==3){
                   echo "<p style='color:red'>Vous devez être connecté pour déposer un fichier </p>";
		   }}
		if(isset($_GET['id'])){
                   echo "<p style='color:green'>Fichier ajouté. </p>";
                }
                ?>
            </form>
        </div>
    </body>
        <script>
    function myFunction() {
    // Les listes des thèmes par Matière
    var themesPC = document.getElementsByName("themeP[]");
    var themesMaths = document.getElementsByName("themeM[]");
    var themesInfo = document.getElementsByName("themeI[]");
    
    // La matière choisie
    var check = document.getElementById("Matière");

    // Le test
    
    if (check.value == "PC"){
      for (var i = 0, len = themesPC.length; i < len; i++) {
			themesPC[i].style.display = "block";
	   }
    }
    if (check.value != "PC"){
      for (var i = 0, len = themesPC.length; i < len; i++) {
						 themesPC[i].checked = false;
						 themesPC[i].style.display = "none";
	   }
    }

						 
    if (check.value == "Maths"){
      for (var i = 0, len = themesMaths.length; i < len; i++) {
			themesMaths[i].style.display = "block";
	   }
    }
    if (check.value != "Maths"){
      for (var i = 0, len = themesMaths.length; i < len; i++) {
						    themesMaths[i].checked = false;
						    themesMaths[i].style.display = "none";
	   }
    }


    if (check.value == "Info"){
      for (var i = 0, len = themesInfo.length; i < len; i++) {
			themesInfo[i].style.display = "block";
	   }
    }
    if (check.value != "Info"){
      for (var i = 0, len = themesInfo.length; i < len; i++) {
						    themesInfo[i].checked = false;
						    themesInfo[i].style.display = "none";
	   }
    }						    
    }						 
</script>
</html>
