<?php include('includes/header_admin.php') ;?>
<link rel="stylesheet" href="compte_admin.css">

 <div class="choix-compte">
     <form class="form-change" action="modif_admin.php" method="post">
         <input type="submit" name="modif-submit" value="Modifier mes informations">
    </form>
    <form class="form-historique" action="modif_plage.php" method="post">
        <input type="submit" name="plage-submit" value="Modifier une plage">
    </form>
    <form class="form-ajout" action="ajout.php" method="post">
        <input type="submit" name="ajout-submit" value="Ajouter">
</form>
<form class="form-ajout" action="suppress_beach.php" method="post">
        <input type="submit" name="suppress-submit" value="Supprimer une plage">
</form>
<form class="form-delete" action="delete_user.php" method="post">
    <input type="submit" name="delete-submit" value="Supprimer Utilisateurs">
</form>
<form class="form-deconnection" action="deco.php" method="post">
    <input type="submit" name="deco-submit" value="Se déconnecter">
</form>
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

