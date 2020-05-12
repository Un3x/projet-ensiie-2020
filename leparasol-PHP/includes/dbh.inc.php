<?php


$config = include('src/config/config.php');
$conn= new \PDO(
    sprintf('pgsql:host=%s;dbname=%s', $config['db']['host'], $config['db']['dbname']),
    $config['db']['user'],
    $config['db']['password']
);

/*$conn = new PDO("pgsql:dbname=LeParasol;host=localhost", "postgres", "53fmcv5" );

if (!$conn){
    die("La connexion à la base de donnée a échoué");
}*/