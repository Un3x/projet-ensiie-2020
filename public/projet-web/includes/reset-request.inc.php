<?php

//PHPMAILER
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'PHPMailer/src/Exception.php';
require 'PHPMailer/src/PHPMailer.php';
require 'PHPMailer/src/SMTP.php';
//--PHPMAILER--

if(isset($_POST['reset-request-submit'])){

    //Création de deux tokens
    $selector=bin2hex(random_bytes(8));
    $token = random_bytes(32);

    //Création du lien de réinitialisation
    $url="http://localhost:8888/projet-web/nav/create-new-password.php?selector=".$selector."&validator=".bin2hex($token);

    $expires=date("U")+1800;

    require 'dbh.inc.php';

    $userEmail=$_POST["mailuid"];

    $sql='DELETE FROM "pwdReset" WHERE "resetEmail"=?';//On supprime si il y a déjà une demande de reset
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/reset-password.php?error=sqlerro");
        exit();
    }else{
        $stmt->execute(array($userEmail));
    }
    //on ajoute les données à la table pwdReset
    $sql='INSERT INTO "pwdReset"("resetEmail","resetSelector","resetToken","resetExpires") VALUES(?,?,?,?)';
    $stmt = $conn->prepare($sql);
    if($stmt == false){
        header("Location: ../nav/reset-password.php?error=sqlerro");
        exit();
    }else{
        $hashedToken=password_hash($token,PASSWORD_DEFAULT);
        $stmt->execute(array($userEmail,$selector,$hashedToken,$expires));
    }

    $stm=null;
    $conn=null;

    $message="<h2>Allez-Retour : Réinitialiser votre mot de passe</h2>";
    $message.="<p>Nous avon reçu une demande de modification de votre mot de passe. Si vous ne souhaitez pas changer votre mot de passe, vous pouvez ignorer cet email.</p>";
    $message.="<p>Pour changer votre mot de passe, cliquez sur ce lien:<br/>";
    $message.='<a href="'.$url.'">'.$url.'</a></p>';

    //PHPMAILER (envois du mail de réinitialisation)
    $mail = new PHPMailer(true);

    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->SMTPSecure ="ssl";
    $mail->Host="smtp.gmail.com";
    $mail->Port=465;
    $mail->isHTML(true);
    $mail->Username='allez.retourc19@gmail.com';
    $mail->Password ="@LLEZ-retour91";
    $mail->SetFrom("noreply@allez-retour.fr");
    $mail->Subject="[Allez-Retour] Changez votre mot de passe";
    $mail->Body = $message;
    $mail->AddAddress($userEmail);
    $mail->send();
    //----PHPMAILER

    header("Location: ../nav/reset-password.php?reset=success");

}else{
    header("Location ../index.php");
}