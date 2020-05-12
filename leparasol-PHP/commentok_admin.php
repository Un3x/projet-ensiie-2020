<?php 
include('includes/header.php');
include('includes/dbh.inc.php');

if(isset( $_POST['post'])){
    $plage=$_POST['plage'];
    $comment=$_POST['comment'];
    $note=$_POST['note'];
    $prenom=$_SESSION['firstname'];
    $nom=$_SESSION['lastname'];

    if (empty($plage)|| empty($comment)||empty($note))  {
        echo  '<p>Veuillez remplir au moins le nom de la plage et le commentaire.</p>
        <p>Cliquez <a href="speaking_admin.php">ici</a> pour revenir</p>';
        ?><footer class="footer">
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

<?php

        exit();
    }
    $verif='SELECT * FROM public."Beach" WHERE name_beach=?';
    $result = $conn->prepare($verif);
    $result->execute(array($plage));
    if (!($result->fetch(PDO::FETCH_ASSOC))) {
        echo '<p>Plage inexistante.</p>
        <p>Cliquez <a href="commentok_admin.php">ici</a> pour revenir</p>';
        exit();
    }
    else {
      $sql3='SELECT * FROM public."Commentaire" WHERE plage=?;';
      $result3 = $conn->prepare($sql3);
      $result3->execute(array($plage));
      while ($result3->fetch(PDO::FETCH_ASSOC)){
        $nombre=$nombre+1;
      }
      $ancienne_note=round($row['note'],1);
    $note_nouvelle=($ancienne_note+$note)/($nombre+1);
        $sql='INSERT INTO public."Commentaire" (commentaire, plage, "Note", nom, prenom) VALUES (?,?,?,?,?);';
        $result = $conn->prepare($sql);
        $result->execute(array($comment,$plage,$note,$nom,$prenom));
        $sql1='UPDATE public."Beach" SET note=? WHERE name_beach=?;'; 
        $result1 = $conn->prepare($sql1);
        $result1->execute(array($note_nouvelle,$plage));
        if ($result){
        echo '<p> Votre commentaire a bien été ajouté! </p> <p> Retourner a l espace échange en cliquant <a href="speak_admin.php">ici</a></p> ';
    }
  }
  }
  ?><footer class="footer">
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
