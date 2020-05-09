<!-- cette page permet de creer un compte 
envoie les informations à Forms/addUser
-->

<!--creer un compte -->
<h1>Nommez votre playlist:</h1>
<form name= "formAddPlaylist" action="Forms/addPlaylist.php" onsubmit="return validCreatePlaylist();" method="POST">
  <label for="name"> Nom de playlist : </label>
  <input type="text" name="name" placeholder="name" maxlength="32"></br>  

Publique ? :
<input type="radio" name="publik" <?php if (isset($publik) && $publik="TRUE") echo "checked"; ?> value="TRUE">Oui 
<input type="radio" name="publik" <?php if (isset($publik) && $publik="FALSE") echo "checked"; ?> value="FALSE">Non
</br>
<button type="submit">Creer la playlist</button>
</br>

<script type="text/javascript" src="scripts/formulaire.js"></script>
