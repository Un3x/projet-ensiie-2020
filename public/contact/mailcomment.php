<?php

	$idsujet=$_GET["id"];
	$db = pg_connect("host=localhost user=toraux dbname=toraux password=ensiie")
                       or die('Erreur de connexion  la base de données');
	$select = "SELECT DISTINCT nom,id,utilisateur,mail FROM sujet INNER JOIN utilisateur ON utilisateur = user_id WHERE id='$idsujet';";
	$exec_requete = pg_query($select)
		      or die('Erreur commande générale');
	if(pg_num_rows($exec_requete) > 0)
               {
	   	 $row = pg_fetch_array($exec_requete);
		 $nomsujet=$row['nom'];
		 $utilisateursujet=$row['utilisateur'];
		 $adresse=$row['mail'];
               }
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
    $mail->addAddress($adresse);               // Name is optional


    // Content
    $mail->Subject = 'Nouveau commentaire sur votre publication';
    $mail->Body    = 'Bonjour '.$utilisateursujet.', nouveau commentaire sur votre publication '.$nomsujet.'.';

    $mail->send();
    echo 'Message has been sent';
    header('Location: ../suj_corr/sujet.php?id='.$idsujet.'');
?>