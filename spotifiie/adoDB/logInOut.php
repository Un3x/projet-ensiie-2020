<?php

function logIn($dbh) {
    if (array_key_exists('login', $_POST) && array_key_exists('mdp', $_POST)) {
        if (Utilisateur::testerMdp($dbh, $_POST['login'], $_POST['mdp'])) {
            $_SESSION['loggedIn'] = True;
            $_SESSION['ecoute'] = "single";
            $_SESSION['enCours'] = 7;
            $_SESSION['Utilisateur']=$_POST['login'];
        }
    }
}

function logOut($dbh) {
    unset($_SESSION['loggedIn']);
    unset($_SESSION['Utilisateur']);
    session_unset();
    session_destroy();
}

function register($dbh) {
    $form_values_valid = false;

    if (
            isset($_POST["nom"]) && $_POST["nom"] != "" &&
            isset($_POST["prenom"]) && $_POST["prenom"] != "" &&
            isset($_POST["login"]) && $_POST["login"] != "" &&
            isset($_POST["email"]) && $_POST["email"] != "" &&
            isset($_POST["birth"]) && $_POST["birth"] != "" &&
            isset($_POST["promotion"]) &&
            isset($_POST["mdp"]) && $_POST["mdp"] != "") 
            {  // tous les champs requis cités ici
        $reussi = Utilisateur::insererUtilisateur($dbh, $_POST["login"], $_POST["mdp"], $_POST["nom"], $_POST["prenom"],$_POST["promotion"], $_POST["birth"], $_POST["email"]);
        if($reussi)
        {
            logIn($dbh);
        }
        else{
            #faire appparaitre une popup disant que l'identification a echoue
        }
    }

    if (!$form_values_valid) {
        // code du formulaire, qui vient d'être écrit
    }
}
