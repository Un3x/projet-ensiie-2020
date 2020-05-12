<?php include('includes/header_admin.php') ;?>

<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script>
$( function() {
  var availabledep = [
  "Ain","Aisne","Allier","Alpes-de-Haute-Provence","Hautes-Alpes","Alpes-Maritimes","Ardeche","Ardennes","Ariege","Aube","Aude","Aveyron","Bouches-du-Rhône","Calvados","Cantal","Charente","Charente-Maritime","Cher","Corrèze","Corse","Cote-d Or","Côtes-d Armor","Creuse","Dordogne","Doubs","Drome","Eure","Eure-et-Loir","Finistere","Gard","Haute-Garonne","Gers","Gironde","Herault","Ille-et-Vilaine","Indre","Indre-et-Loire","Isere","Jura","Landes","Loir-et-Cher","Loire","Haute-Loire","Loire-Atlantique","Loiret","Lot","Lot-et-Garonne","Lozere","Maine-et-Loire","Manche","Marne","Haute-Marne","Mayenne","Meurthe-et-Moselle","Meuse","Morbihan","Moselle","Nievre","Nord","Oise","Orne","Pas-de-Calais","Puy-de-Deme","Pyrenees-Atlantiques","Hautes-Pyrenees","Pyrenees-Orientales","Bas-Rhin","Haut-Rhin","Haute-Saone","Saone-et-Loire","Sarthe","Savoie","Haute-Savoie","Paris","Seine-Maritime","Seine-et-Marne","Yvelines","Deux-Sevres","Somme","Tarn","Tarn-et-Garonne","Var","Vaucluse","Vendee","Vienne" ,"Haute-Vienne","Vosges","Yonne","Territoire de Belfort","Essonne","Hauts-de-Seine","Seine-Saint-Denis","Val-de-Marne","Val-d Oise"
  ];
  var availablechoice1 = ["nudiste","non nudiste"];
  var availablechoice2 = ["publique","privée"];
  
  $( "#dep" ).autocomplete({
    source: availabledep
  });
  $( "#choice1" ).autocomplete({
    source: availablechoice1
  });
  $( "#choice2" ).autocomplete({
  source: availablechoice2
  });
  
} );
</script>


    <div id="find-box">
        <div class="center"> 
          <h1 class="add"> Ajouter </h1>
          <form class="form_add" action="beach_ajout.php" method="post">
          <input type="text" name="city" placeholder="Ville" />
          <input id="dep" type="text" name="departement" placeholder="Département" autocomplete="off" />
          <input type="text" name="beach" placeholder="Nom de la Plage" /> 
          <input type="text" name="caracteristics" placeholder="Type" >
          <input id="choice2" type="text" name="privacy" placeholder="Propriété" >
          <input id="choice1" type="text" name="nudity" placeholder="Particularité" >  
          <input type="text" name="frequentation" placeholder="Frequentation">
          <input type="text" name="note" placeholder="Note/5">
          <textarea type="text" name="description" placeholder="Description"></textarea>
          <input type="submit" name="add_submit" value="Ajouter" />
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