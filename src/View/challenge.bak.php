<?php include_once 'layout/header.php' ?>
  <!-- Iterface pour les challenges-->
<div class="container">
  <div class="row pt-5">
    <div class="col-12">
      <p>[DEV] Cette page présente une version antérieure du jeu et encore a développer. Elle est partiellement fonctionnelle que vous pouvez essayer.</p>
      <p>[DEV] Pour ajouter une transition, il faut d'abord disposer de deux états, puis sélectionner l'état de départ et l'état d'arrivé après avoir appuyé sur le bouton "Ajouter une transition". Pour retirer une transition ou un état, il faut le sélectionner, puis utiliser le bouton qui s'affiche. Les sommets supportent le glissé-déposé !</p>
      <p>[DEV] Cette version est bien plus évoluée et complexe qu'avec un affichage statique. Il manque encore la mise en place du choix des symboles, de la gestion des arcs doubles - deux arcs réciproques entre deux sommets - et des arcs "réflexifs" sur un même sommet. Le problème se trouve également dans la gestion dynamique au drag and drop de l'affichage des arcs particuliers - doubles et réflexifs - et des symboles.</p>
      <!-- Pour plus d'informations : thomasmeyer@outlook.fr -->
    </div>
  </div>
  <div class="row pt-3">
    <div class="col-8">
      <div>
        <h2>Mon automate</h2>
      </div>
      <div>
        <div id="container"></div>
      </div>
      <div>
        <button type="button" class="btn btn-primary" id="add-state">Ajouter un état</button>
        <button type="button" class="btn btn-primary" id="add-transition">Ajouter une transition</button>
        <button type="button" class="btn btn-danger" style="display:none" id="remove-state">Retirer un état</button>
        <button type="button" class="btn btn-danger" style="display:none" id="remove-transition">Retirer une transition</button>
      </div>
    </div>
    <div class="col-4">
      <h2>Séquences</h2>
      <div id="sequences"></div>
    </div>
  </div>
</div>
<script src="js/konva-4.0.0.min.js"></script>
<script src="js/scripts.bak.js"></script>
<script>

var model = new Model();
var view = new View();

$(document).ready(function() {

  $("#add-state").click(function() {
    var id = model.addState();
    view.addState(id, 100, 100);
  });

  $("#add-transition").click(function() {
    view.createTransition = true;
  });

  $("#remove-state").click(function() {
    var id = Number(view.removeState());
    model.removeState(id);
    $(this).hide();
  });

  $("#remove-transition").click(function() {
    var ids = view.removeTransition();
    model.removeTransitions(ids[0], ids[1]);
    $(this).hide();
  });
});
</script>

<?php include_once 'layout/footer.php' ?>
