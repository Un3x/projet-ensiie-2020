<?php

if (isset($_POST["signup-submit"])) { //on vérifie que l'utilisateur a bien cliqué sur le bouton s'inscrire pour accéder à cette page
    require 'dbh.inc.php'; //Connection à la db
    //on récupere les données du formulaire d'inscription
    $nom = $_POST["nom"];
    $prenom = $_POST["prenom"];
    $mail = $_POST["mailuid"];
    $tel = $_POST["tel"];
    $password = $_POST["pwd"];
    $passwordRepeat = $_POST["pwd-repeat"];
    $profil = $_FILES['profil']['name'];

    //caractéristiques photo
    $taillemax = 2097152; //2 Mo de place
    $extensionsValides = array('jpg','jpeg', 'gif','png');

    if($_FILES['profil']['size'] <= $taillemax){
        $extensionUpload = strtolower(substr(strrchr($profil,"."), 1));
        if(in_array($extensionUpload, $extensionsValides)){
            $chemin = "../img/membre/".$nom.".".$extensionUpload;
            $res = move_uploaded_file($_FILES['profil']['tmp_name'], $chemin);
        }
        else{
        header("Location: ../nav/inscription.php?error=photomauvaisformat&mail=".$mail."&nom=".$nom."&prenom=".$prenom."&tel=".$tel);
        }

    }

    if(!filter_var($mail,FILTER_VALIDATE_EMAIL) && !preg_match("/^[a-zA-Z0-9]*$/",$nom.$prenom)){//si nom, prénom et mail sont invalides
        header("Location: ../nav/inscription.php?error=invalidmailnomprenom&tel=".$tel);
        exit();

    }else if(!filter_var($mail,FILTER_VALIDATE_EMAIL)){//On vérifie si l'email est valide
        header("Location: ../nav/inscription.php?error=invalidmail&nom=".$nom."&prenom=".$prenom."&tel=".$tel);
        exit();
    }else if(!preg_match("/^[a-zA-Z0-9]*$/",$nom.$prenom)){//On vérifie si nom et prénom son valide
        header("Location: ../nav/inscription.php?error=invalidnom_ou_prenom&mail=".$mail."&tel=".$tel);
        exit();
    }else if($password !== $passwordRepeat){//si les mots de passe ne sont pas identiques
        header("Location: ../nav/inscription.php?error=passwordcheckl&mail=".$mail."&nom=".$nom."&prenom=".$prenom."&tel=".$tel);
        exit();
    }
    else{
        $sql = "SELECT mail FROM utilisateur WHERE mail=?";
        $stmt = $conn->prepare($sql);
        if($stmt == false){
            header("Location: ../nav/inscription.php?error=sqlerror");
            exit();
}else{
            $stmt->execute(array($mail));
            $result = $stmt->fetchAll(PDO::FETCH_COLUMN,0);
            if (count($result) > 0){//Si on trouve une adresse mail correspondante dans la bdd, erreur.
                header("Location: ../nav/inscription.php?error=mailtaken&nom=".$nom."&prenom=".$prenom);
                exit();
}else{ //À ce stade, on a vérifié que l'adresse mail n'est pas dans la db et dans ce cas on insère les nouvelles données

                if(!empty($profil)){

                $sql="INSERT INTO utilisateur (nom,prenom,mail,tel,pwd,droit,profil) VALUES (?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                if($stmt == false){
                    header("Location: ../nav/inscription.php?error=sqlerror");
                    exit();
                }else{
                    $hashedpwd=password_hash($password,PASSWORD_DEFAULT); //On hash le pwd
                    $stmt->execute(array($nom,$prenom,$mail,$tel,$hashedpwd,1,$nom.".".$extensionUpload));
                    header("Location: ../nav/connexion.php?signup=success");
                    exit();
                }




                }else{

                $sql="INSERT INTO utilisateur (nom,prenom,mail,tel,pwd,droit,profil) VALUES (?,?,?,?,?,?,?)";
                $stmt = $conn->prepare($sql);
                if($stmt == false){
                    header("Location: ../nav/inscription.php?error=sqlerror");
                    exit();
                }else{
                    $hashedpwd=password_hash($password,PASSWORD_DEFAULT); //On hash le pwd
                    $stmt->execute(array($nom,$prenom,$mail,$tel,$hashedpwd,1,"vide"));
                    header("Location: ../nav/connexion.php?signup=success");
                    exit();
                }







                }



}
}
        $stm=null; //Fermeture de la connexion à la bd
        $conn=null;
}
    
}else{
    header("Location: ../nav/connexion.php"); //Dans le cas où l'user n'arrive pas sur cette page grâce au bouton s'inscrire on le redirige vers la page de connexion
    exit();
}


?>