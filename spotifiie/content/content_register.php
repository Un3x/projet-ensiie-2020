<h2>Inscivez vous facilement et gratuitement</h2>
<form action="index.php?page=register&todo=register" method=post
      oninput="mdp2.setCustomValidity(mdp2.value != mdp.value ? 'Les mots de passe diffèrent.' : '')">
  <p>
  <label for="nom">Nom(*) :</label>
  <input id="nom" type=text required name=nom>
 </p>
 
 <p>
  <label for="prenom">Prénom(*) :</label>
  <input id="prenom" type=text required name=prenom>
 </p>
    
 <p>
  <label for="login">Nom d'utilisateur(*) :</label>
  <input id="login" type=text required name=login>
 </p>

  <p>
  <label for="email">Adresse email(*) :</label>
  <input id="email" type=email required name=email>
 </p>
 
 <p>
  <label for="birth">Date de naissance(*) :</label>
  <input id="birth" type=date required name=birth>
 </p>
 
 <p>
  <label for="promotion">Promotion :</label>
  <input id="promotion" type=number required name=promotion>
 </p>
 
 <p>
  <label for="password1">Mot de passe(*) :</label>
  <input id="password1" type=password required name=mdp>
 </p>
 <p>
  <label for="password2">Confirmer mot de passe(*) :</label>
  <input id="password2" type=password name=mdp2>
 </p>
  <input type=submit value="Valider">
</form>


