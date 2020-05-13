<?php

if(isset($_POST["reset-password-submit"])){

    $selector=$_POST["selector"];
    $validator=$_POST["validator"];
    $newPwd=$_POST["new-password"];
    $newPwdRepeat=$_POST["new-password-repeat"];

    if(empty($newPwd) || empty($newPwdRepeat)){
        header("Location: ../nav/create-new-password.php?error=empty");
        exit();
    }else if($newPwd !== $newPwdRepeat){
        header("Location: ../nav/create-new-password.php?error=pwdnotsame&selector=".$selector."&validator=".$validator);
        exit();
    }

    $currentDate=date("U");

    require 'dbh.inc.php';

    $sql='SELECT * FROM "pwdReset" WHERE "resetSelector"=?';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/create-new-password.php?error=sqlerror");
        exit();
    }else{
        $stmt->execute(array($selector));
        $result = $stmt->fetchAll();
        if(count($result)>0){
            foreach($result as $row){
                $tokenBin = hex2bin($validator);
                $tokenCheck = password_verify($tokenBin,$row['resetToken']);//On vérifie que les tokens match
            }

            if($tokenCheck === false){
                echo "fatal error, recommencez la demande de changement de mot de passe 1ER ERREUR";
                exit();
            }else if($tokenCheck === true){
                foreach($result as $row){
                    $tokenEmail = $row['resetEmail'];
                }

                $sql = 'SELECT * FROM "utilisateur" WHERE "mail" = ?';
                $stmt = $conn->prepare($sql);
                if($stmt == false){
                    header("Location: ../nav/create-new-password.php?error=sqlerror");
                    exit();
                }else{
                    $stmt->execute(array($tokenEmail));
                    $result = $stmt->fetchAll();
                    if(count($result)>0){

                        $sql='UPDATE "utilisateur" SET "pwd"=? WHERE "mail"=?';
                        $stmt = $conn->prepare($sql);
                        if($stmt == false){
                            header("Location: ../nav/create-new-password.php?error=sqlerror");
                            exit();
                        }else{
                        $newPwdHashed=password_hash($newPwd,PASSWORD_DEFAULT);
                        $stmt->execute(array($newPwdHashed,$tokenEmail)); //On change le pwd
                        }
                    }else{
                        echo "<p>Cette adresse mail n'est pas dans la base de donnée, Veuillez créez un compte <a href='/projet-web/nav/inscription.php'>ici</a></p>";
                        exit();
                    }

                    $sql='DELETE FROM "pwdReset" WHERE "resetEmail"=?';
                    $stmt = $conn->prepare($sql);
                    if($stmt == false){
                        header("Location: ../nav/create-new-password.php?error=sqlerror");
                        exit();
                    }else{
                        $stmt->execute(array($tokenEmail));
                        header("Location: ../nav/connexion.php?pwd=changed");
                    }
                    
            }
        }
        }
        else{
            echo "fatal error, recommencez la demande de changement de mot de passe 3E ERREUR";
            exit();
        }
    }


}else{
    header("Location: ../index.php");
}