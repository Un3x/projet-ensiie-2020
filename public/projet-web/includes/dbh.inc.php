<?php

$conn = new PDO("pgsql:dbname=allez-retour;host=localhost", "postgres", "1112" );
//$conn = new PDO("pgsql:dbname=allez-retour;host=localhost", "user", "pwd" );

if (!$conn){
    die("La connexion à la base de donnée a échoué");
}