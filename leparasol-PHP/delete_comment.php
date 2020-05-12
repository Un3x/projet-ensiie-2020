<?php include('includes/header_admin.php') ;?>

 <?php 
include('includes/dbh.inc.php');

if (isset($_POST['delete']))
{
  $id=$_POST['id'];
    $sql='DELETE FROM public."Commentaire"
    WHERE id=?';
    $result = $conn->prepare($sql);
    $result->execute(array($id));
    $sql1='DELETE FROM public."Reponse"
    WHERE id=?';
    $result1 = $conn->prepare($sql1);
    $result1->execute(array($id));
    if ($result1 && $result) {
      echo '<p> Le commentaire et ses réponses ont bien été supprimé.</p> <p>Cliquez <a href="speak_admin.php">ici</a> pour revenir à l espace d échange entre les internautes </p>';
    }
  }
?>

<div id="find-box">
        <div class="center"> 
          <h1 class="finding"> Supprimer </h1>
          <form class="finding_beach" action="delete_comment.php" method="post">
          <input type="text" name="id" placeholder="Identifiant du commentaire" />   
          <input type="submit" name="delete" value="Supprimer" />
          </form>
    </div>
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
            <a href="#">Conditions d'utilisation</a>
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

</html>
