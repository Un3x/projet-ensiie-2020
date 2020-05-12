<?php
session_start();
error_reporting(E_ALL);
ini_set('display_errors', 1);

include_once '../src/Model/Factory/dbFactory.php';
include_once '../src/Model/Entity/Utilisateur.php';

function isAuthenticated()
{
    return (isset($_SESSION["Authenticated"]) && $_SESSION["Authenticated"] == 1);
}

function getDroits()
{
    $droits = "visiteur";
    if (isAuthenticated()) {
        $droits = $_SESSION["Droits"];
    }
    return $droits;
}
