<?php
    session_start();
    require 'dbh.inc.php';
    $userId=$_SESSION["userId"];

if(isset($_POST["modifierInfos"])){
    
    $newNom=$_POST["nomModif"];
    $newPrenom=$_POST["prenomModif"];
    $newTel=$_POST["telModif"];
    $newMail=$_POST["mailModif"];
    $newVoiture=$_POST["voitureModif"];
    $profil = $_FILES['profil']['name'];

    //caractéristiques photo
    $taillemax = 2097152; //2 Mo de place
    $extensionsValides = array('jpg','jpeg', 'gif','png');

    if($_FILES['profil']['size'] <= $taillemax){
        $extensionUpload = strtolower(substr(strrchr($profil,"."), 1));
    if(in_array($extensionUpload, $extensionsValides)){
            $chemin = "../img/membre/".$newNom.".".$extensionUpload;
            $res = move_uploaded_file($_FILES['profil']['tmp_name'], $chemin);
    }else{
        header("Location: ../nav/modifier-information.php?error=photomauvaisformat");
    }
}

    //TODO : Ajouter la vérification de l'existence de la nouvelle adresse dans la bdd

    if(!filter_var($newMail,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$newNom.$newPrenom)){//si nom, prénom et mail sont invalides
        header("Location: ../nav/modifier-information.php?error=invalidmailnomprenom&tel=".$tel);
        exit();

    }else if(!filter_var($newMail,FILTER_VALIDATE_EMAIL)){//On vérifie si l'email est valide
        header("Location: ../nav/modifier-information.php?error=invalidmail&nom=".$newNom."&prenom=".$newPrenom."&tel=".$newTel);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$newNom.$newPrenom)){//On vérifie si nom et prénom son valide
        header("Location: ../nav/modifier-information.php?error=invalidnom_ou_prenom&mail=".$newMail);
        exit();
    }
    if (!empty($_FILES['profil']['name'])) {

            $sql='UPDATE utilisateur SET nom=?,prenom=?,mail=?,modele_voiture=?,tel=?,profil=? WHERE id_utilisateur=?';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/information.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($newNom,$newPrenom,$newMail,$newVoiture,$newTel,$newNom.".".$extensionUpload,$_SESSION["userId"])); //On change les infos
        $_SESSION['userMail'] = $newMail;
        $_SESSION['userNom'] = $newNom;
        $_SESSION['userPrenom'] = $newPrenom;
        $_SESSION['userTel'] = $newTel;
        $_SESSION['userVoiture'] = $newVoiture;
        header("Location: ../nav/monCompte.php?success=infomodifiedcas1");
    }

    }else{


    $sql='UPDATE utilisateur SET nom=?,prenom=?,mail=?,modele_voiture=?,tel=? WHERE id_utilisateur=?';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/information.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($newNom,$newPrenom,$newMail,$newVoiture,$newTel,$_SESSION["userId"])); //On change les infos
        $_SESSION['userMail'] = $newMail;
        $_SESSION['userNom'] = $newNom;
        $_SESSION['userPrenom'] = $newPrenom;
        $_SESSION['userTel'] = $newTel;
        $_SESSION['userVoiture'] = $newVoiture;
        header("Location: ../nav/monCompte.php?success=infomodifiedcas2");
    }


    }


}else if(isset($_POST["deletephoto"])){
    $profil = "vide";
    $sql = "UPDATE utilisateur SET profil=? WHERE id_utilisateur=?";
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/information.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($profil,$userId));
        header("Location: ../nav/modifier-information.php?success=infomodified3");
    }

}else{
    header("Location: ../nav/monCompte.php");
    exit();
}