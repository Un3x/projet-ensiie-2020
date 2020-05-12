<html>
    <head>
       <meta charset="utf-8">
       <link rel="stylesheet" href="style/style2.css"/>
    </head>
    <body>
        <div id="header" class="header">
         <?php
                session_start();
                if(isset($_SESSION['username'])){
                    $user = $_SESSION['username'];
                    echo "<div style='position:relative; top:0px; right:0px; text-align:right;'>Bonjour $user, vous êtes connecté</div>";
	        }
	        $admin=0;
	        if(isset($_SESSION['admin'])){
	           $admin = $_SESSION['admin'];
	        }
	        if(isset($_GET['deletesujet']) && $admin == 1)
	        {
	         $db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');    
	         $iddelete=$_GET['deletesujet'];
	         $selectcorrect = "SELECT nomcorrection FROM correction WHERE id='$iddelete'";
	         $select_correct = pg_query($selectcorrect)
	            or die('Erreur commande trouver correction');
	         while ($row = pg_fetch_array($select_correct)){
	            $Path="Corrections/".$row['nomcorrection'];
	            unlink($Path);
	         }
	         $selectsujet = "SELECT nom FROM sujet WHERE id='$iddelete'";
	         $select_requete = pg_query($selectsujet)
	    or die('Erreur commande trouver sujet!');
	         $row = pg_fetch_array($select_requete);
	         $Path="Sujets/".$row['nom'];
	         unlink($Path);
	         $deletesujet = "DELETE FROM sujet WHERE id='$iddelete'";
	         $delete_requete = pg_query($deletesujet)
	         or die('Erreur commande supprimer sujet!');
	       }
            ?>
         <img src="style/logo.png" alt="logo" style="width:150px;height:150px;">
	 <h1>T-Oraux</h1>
	 <div class="header-right">
	 <a href="accueil.php">Accueil</a>
	 <?php
	 if(isset($_SESSION['username'])){   
	   $link_profil="profil.php?id=".$user."";
	   echo "<a href='".$link_profil."'>Mon Profil</a>";
	 }
	 ?>
	 <a href="contact/contact.php">Contact</a>
 	 <?php
	 if(isset($_SESSION['username'])){   
	   echo "<a href=index.php?state=0>Déconnexion</a>";
	 }
	 else{
	   echo "<a href=index.php>Connexion</a>";
	 }
	 ?>
         </div>
        </div>
        <div id="container">
            <form action="find.php" method="POST">
	    
                <h1 style="width:100%">Recherche de Sujet</h1>
		
                <label><b>Matière:</b></label>
                <select id="Matière" name="Matière" onclick="myFunction()">
		        <option>Choisir Matière</option>
   			<option value="Maths">Mathématiques</option>
			<option value="PC">Physique-Chimie</option>
			<option value="Info">Informatique</option>
    	        	<option value="SI">SI</option>
  		</select>
		
		<br>
		<br>
                <label><b>Filière:</b></label><br/>
                <input type="checkbox" id="MPSI" name="filiere[]" value="MPSI">
  		<label for="MPSI">MPSI</label><br>
		
  		<input type="checkbox" id="MP" name="filiere[]" value="MP">
  		<label for="MP"> MP</label><br>
		
  		<input type="checkbox" id="PCSI" name="filiere[]" value="PCSI">
  		<label for="PCSI">PCSI</label><br>
		
		<input type="checkbox" id="PC" name="filiere[]" value="PC">
  		<label for="PC">PC</label><br>
		
		<input type="checkbox" id="TSI" name="filiere[]" value="TSI">
  		<label for="TSI">TSI</label><br>

		<input type="checkbox" id="PSI" name="filiere[]" value="PSI">
  		<label for="PSI">PSI</label><br>

		<input type="checkbox" id="BCPST" name="filiere[]" value="BCPST">
  		<label for="BCPST">BCPST</label><br>

		<input type="checkbox" id="ATS" name="filiere[]" value="ATS">
  		<label for="ATS">ATS</label><br>

		<br>
			
                <label><b>Année:</b></label>
		<?php $years = range(1990, strftime("%Y", time())); ?>
		<select id="annee" name="annee">
		  <option>Choisir Année</option>
		  <?php foreach($years as $year) : ?>
		  <option value="<?php echo $year; ?>"><?php echo $year; ?></option>
		  <?php endforeach; ?>
		</select>

		<br>
		<br>

		
                <label><b>Concours:</b></label><br/>
                <input type="checkbox" id="CCP" name="concours[]" value="CCP">
  		<label for="CCP">CCP</label><br>
		
  		<input type="checkbox" id="MT" name="concours[]" value="MT">
  		<label for="MT"> Mines-Ponts/Mines-Télécom</label><br>
		
  		<input type="checkbox" id="EIVPTPE" name="concours[]" value="EIVPTPE">
  		<label for="EIVPTPE">EIVP-TPE</label><br>
		
		<input type="checkbox" id="X" name="concours[]" value="X">
  		<label for="X">X/ENS</label><br>
		
		<input type="checkbox" id="E3A" name="concours[]" value="E3A">
  		<label for="E3A">E3A</label><br>

		<input type="checkbox" id="CENTRALE" name="concours[]" value="CENTRALE">
  		<label for="CENTRALE">Centrale-Supélec</label><br>

		<input type="checkbox" id="ARTSETMETIERS" name="concours[]" value="ARTSETMETIERS">
  		<label for="ARTSETMETIERS">Arts et Métiers</label>

		<br>
		<br>

		<label><b>Thèmes:</b></label><br/>
                <input type="checkbox" id="Algèbre" name="themeM[]" value="Algèbre" style="display: none">
		<label for="Algèbre" name="themeM[]" style="display: none">Algèbre</label>
		<br name="themeM[]" style="dispay: none">
		
		<input type="checkbox" id="Topologie" name="themeM[]" value="Topologie" style="display: none">
  		<label for="Topologie" name="themeM[]" style="display: none">Topologie</label>
		<br name="themeM[]" style="display: none">
		
		<input type="checkbox" id="Fonction et intégration" name="themeM[]" value="Fonction et intégration" style="display: none">
  		<label for="Fonction et intégration" name="themeM[]" style="display: none">Fonctions et intégration</label>
		<br name="themeM[]" style="display: none">
		
		<input type="checkbox" id="Séries" name="themeM[]" value="Séries" style="display: none">
  		<label for="Séries" name="themeM[]" style="display: none">Séries</label>
		<br name="themeM[]" style="display: none">

		<input type="checkbox" id="Calcul différentiel" name="themeM[]" value="Calcul différentiel" style="display: none">
  		<label for="Calcul différentiel" name="themeM[]" style="display: none">Calcul différentiel</label>
		<br name="themeM[]" style="display: none">

		<input type="checkbox" id="Probabilités" name="themeM[]" value="Probabilités" style="display: none">
  		<label for="Probabilités" name="themeM[]" style="display: none">Probabilités</label>
		<br name="themeM[]" style="display: none">
		
  		<input type="checkbox" id="Mécanique" name="themeP[]" value="Mécanique" style="display: none">
  		<label for="Mécanique" name="themeP[]" style="display: none">Mécanique</label>
		<br name="themeP[]" style="display: none">
		
		<input type="checkbox" id="Optique" name="themeP[]" value="Optique" style="display: none">
  		<label for="Optique" name="themeP[]" style="display: none">Optique</label>
		<br name="themeP[]" style="display: none">
		
		<input type="checkbox" id="Electromagnétisme" name="themeP[]" value="Electromagnétisme" style="display: none">
  		<label for="Electromagnétisme" name="themeP[]" style="display: none">Electromagnétisme</label>
		<br name="themeP[]" style="display: none">
		
		<input type="checkbox" id="Electronique" name="themeP[]" value="Electronique" style="display: none">
  		<label for="Electronique" name="themeP[]" style="display: none">Electronique</label>
		<br name="themeP[]" style="display: none">

		<input type="checkbox" id="Thermodynamique" name="themeP[]" value="Thermodynamique" style="display: none">
  		<label for="Thermodynamique" name="themeP[]" style="display: none">Thermodynamique</label>
		<br name="themeP[]" style="display: none">

		<input type="checkbox" id="Physique des ondes" name="themeP[]" value="Physique des ondes" style="display: none">
  		<label for="Physique des ondes" name="themeP[]" style="display: none">Physique des ondes</label>
		<br name="themeP[]" style="display: none">

		<input type="checkbox" id="Cinétique chimique" name="themeP[]" value="Cinétique chimique" style="display: none">
  		<label for="Cinétique chimique" name="themeP[]" style="display: none">Cinétique chimique</label>
		<br name="themeP[]" style="display: none">

		<input type="checkbox" id="Structure de la matière" name="themeP[]" value="Structure de la matière" style="display: none">
  		<label for="Structure de la matière" name="themeP[]" style="display: none">Structure de la matière</label>
		<br name="themeP[]" style="display: none">

		<input type="checkbox" id="Graphes" name="themeI[]" value="Graphes" style="display: none">
  		<label for="Graphes" name="themeI[]" style="display: none">Graphes</label>
		<br name="themeI[]" style="display: none">
		
		<input type="checkbox" id="Arbres" name="themeI[]" value="Arbres" style="display: none">
  		<label for="Arbres" name="themeI[]" style="display: none">Arbres</label>
		<br name="themeI[]" style="display: none">

		
		<input type="submit" value="Rechercher">

		
                <?php
                if(isset($_GET['erreur'])){
                    $err = $_GET['erreur'];
                    if($err==1 || $err==2)
                        echo "<p style='color:red'>Aucun sujet ne convient. Assurez vous de selectionner une matière</p>";
                }
                ?>
            </form>
	    <p id="containe"></p>
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
