<h1>Contenu de la playlist $name</h1>
<?php
if isset($_GET["contents"]){
  echo reset($contents);
  
}
?>