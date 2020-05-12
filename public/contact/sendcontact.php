<?php

	$nom = $_POST['name'];
	$adresse = $_POST['mail'];
	$message = $_POST['message'];

// Load Composer's autoloader
require 'PHPMailer/PHPMailerAutoload.php';

// Instantiation and passing `true` enables exceptions
$mail = new PHPMailer(true);

    //Server settings
    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      // Enable verbose debug output
    $mail->isSMTP();                                            // Send using SMTP
    $mail->Host       = 'smtp.gmail.com';                    // Set the SMTP server to send through
    $mail->SMTPAuth   = true;                                   // Enable SMTP authentication
    $mail->Username   = 'toraux.noreply@gmail.com';                     // SMTP username
    $mail->Password   = 'TORAUXsite';                               // SMTP password
    $mail->Port       = 587;                                    // TCP port to connect to

    //Recipients
    $mail->setFrom('toraux.noreply@gmail.com', "T'Oraux");
    $mail->addAddress('a.elmahouli@gmail.com');               // Name is optional


    // Content
    $mail->isHTML(true);
    $mail->Subject = 'Message de '.$nom.'';
    $mail->Body    = '<b>Nom : </b> '.$nom.'<br> <b>Email : </b>'.$adresse.' <br> <b>Message : </b>'.$message.'';

    $mail->send();
    echo 'Message has been sent';
    header('Location: contact.php');
?>