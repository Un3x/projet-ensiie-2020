<div class="header">
    <?php
	if (isset($_SESSION['n_pers'])&isset($_SESSION['nom'])):?>
		<a href="profile.php">Zoubir-Social-Club.</a>
		<div class="right">
			<div class="nomprenom">
				<?php echo $_SESSION['prenom']; echo" ";echo $_SESSION['nom'];?>
			</div>
		</div>
	<ul id="nav">
		<li id="nav-search"><a href="search.php">Recherche</a></li>
    	<li id="nav-home"><a href="write_mess.php">Poster</a></li>
   	    <li id="nav-about"><a href="profile.php">Mon profil</a></li>
   	    <li id="nav-archive"><a href="abonnement.php">Mes abonnements</a></li>
		<li id="nav-mon_mur"><a href="search.php?q=<?php echo $_SESSION['prenom']?>">Mon mur</a></li>
		<li id="nav-newsfeed"><a href="newsfeed.php">Mon fil d'actualités</a></li>
		<div class="right">
			<li id="nav-archive"><a href="deconnexion.php">Deconnexion</a></li>
		</div>
    </ul>
   <?php else:?>
	<a href="index.php">Zoubir-Social-Club.</a>
   		<ul id="nav">
    		<li id="nav-home"><a href="signup.php">Inscription</a></li>
   	   		<li id="nav-about"><a href="login.php">Connexion</a></li>
    	</ul>
   <?php endif;?>
   
    
</div>