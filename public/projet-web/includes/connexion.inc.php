<?php

if(isset($_POST["login-submit"])){
    require 'dbh.inc.php';

    $mail = $_POST["mailuid"];
    $pwd = $_POST["pwd"];

    if(empty($mail) || empty($pwd)){
        header("Location: ../nav/connexion.php?error=emptyfields");
        exit();
    }else{
        $sql = "SELECT * FROM utilisateur WHERE mail=?";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            header("Location: ../nav/connexion.php?error=sqlerro");
            exit();
        }else{
            $stmt->execute(array($mail));
            $result = $stmt->fetchAll();
            if(count($result)>0){
                foreach($result as $row){
                    $pwdCheck = password_verify($pwd,$row['pwd']);
                    $id_utilisateur=$row['id_utilisateur'];
                    $nom_utilisateur=$row['nom'];
                    $prenom_utilisateur=$row['prenom'];
                    $tel_utilisateur=$row['tel'];
                    $modele_voiture=$row['modele_voiture'];
                    $userDroit=$row['droit'];
                }
                if($pwdCheck==false){
                    header("Location: ../nav/connexion.php?error=wrongpwd");
                    exit();
                }else if($pwdCheck==true){
                    session_start(); //Si la connexion est accordé, on crée la session et on récupère les données de l'utilisateur
                    $_SESSION['userMail'] = $mail;
                    $_SESSION['userId'] = $id_utilisateur;
                    $_SESSION['userNom'] = $nom_utilisateur;
                    $_SESSION['userPrenom'] = $prenom_utilisateur;
                    $_SESSION['userTel'] = $tel_utilisateur;
                    $_SESSION['userVoiture'] = $modele_voiture;
                    $_SESSION['userDroit'] = $userDroit;
                    header("Location: ../index.php?login=success");
                }
                else{
                    header("Location: ../nav/connexion.php?error=wrongpwd");
                    exit();
                }

            }else{
                header("Location: ../nav/connexion.php?error=wrongmail");
            }
        }
    }
    $stm=null;
    $conn=null;


}else{
    header("Location: ../connexion.php");
    exit();
}