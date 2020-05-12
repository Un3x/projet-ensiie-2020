<?php include_once 'layout/header.php' ?>

<div class="container">
  <!-- Comme le jeu est en JavaScript, on affiche un message en son abscence -->
  <noscript class="text-center">
    <h1 class="display-1 my-5">Pas de JavaScript !</h1>
    <p class="lead my-5">Le jeu a besoin de la technologie JavaScript pour fonctionner !</p>
  </noscript>
  <!-- Jeu -->
  <div id="container" class="mx-auto"></div>
  <!-- Modal -->
  <div class="modal fade" id="select-symbol-modal" tabindex="-1" role="dialog" aria-labelledby="select-symbol-modal" aria-hidden="true">
    <div class="modal-dialog" role="document">
      <div class="modal-content">
        <div class="modal-body" id="select-symbol"></div>
      </div>
    </div>
  </div>
  <!-- Séquences -->
  <div class="card custom-width mx-auto shadow">
    <div class="card-body">
      <button class="btn btn-secondary btn-block mb-3" id="eval-all">Tester</button>
      <ul class="list-group" id="select-sequence"></ul>
      <button class="btn btn-primary btn-block mt-3" id="send-all">Envoyer</button>
    </div>
  </div>
  
  <div class="text-center mt-5 pt-5">
    <a href="/challenge.dev.php">Version alpha du jeu</a>
  </div>
</div>




<script src="js/konva-4.0.0.min.js"></script>
<script src="js/scripts.js"></script>

<!-- Plutôt qu'un stockage en BDD, on peut utiliser un stockage en système de fichier -->
<script src="json/challenge<?= $data['id'] ?>.js"></script>
<!--<script src="json/played-<?= $data['id'] ?>-<id du joueur>.js"></script>-->

<script>
var foreground = {
  symbolsOfTransition: [
    [true, true],
    [false, false],
    [false, false],
    [false, false]
  ]
};

var game = new Game(background, foreground);
game.draw();

document.getElementById("eval-all").addEventListener("click", function (e) {
  game.evalAll();
});

</script>

<?php include_once 'layout/footer.php' ?>
