<?php
class dbFactory {
  function createService() {
    return new PDO('pgsql:dbname=vocasiite;host=localhost', 'ensiie', 'ensiie');
  }
}
?>
