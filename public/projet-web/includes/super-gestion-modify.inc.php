<?php
session_start();

if(isset($_POST["modif-submit"])){
    require 'dbh.inc.php';
    $id=$_POST["idHiden"];
    if($_SESSION["userDroits"] === 3){
        $droit=$_POST["droitHiden"];
    }
    $newNom=$_POST["nom"];
    $newPrenom=$_POST["prenom"];
    $newTel=$_POST["tel"];
    $newMail=$_POST["mail"];
    $newVoiture=$_POST["voiture"];

    //TODO : Ajouter la vérification de l'existence de la nouvelle adresse dans la bdd

    if($_SESSION["userDroits"] === 3){
        $sql='UPDATE utilisateur SET nom=?,prenom=?,mail=?,modele_voiture=?,tel=?,droit=? WHERE id_utilisateur=?';
    }else{
        $sql='UPDATE utilisateur SET nom=?,prenom=?,mail=?,modele_voiture=?,tel=? WHERE id_utilisateur=?';
    }
    
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/super-gestion.php?error=sqlerror");
        exit();
    }else{
        if($_SESSION["userDroits"] === 3){
            $stmt->execute(array($newNom,$newPrenom,$newMail,$newVoiture,$newTel,$droit,$id)); //On change les infos
        }else{
            $stmt->execute(array($newNom,$newPrenom,$newMail,$newVoiture,$newTel,$id)); //On change les infos
        }

        header("Location: ../nav/monCompte.php#supergestion?success=infomodified");
    }
}else{
    header("Location: /projet-web/index.php?error=failed");
    exit();
}