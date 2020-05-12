      <?php

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
    $mail->setFrom('toraux.noreply@gmail.com', 'Mailer');
    $mail->addAddress('a.elmahouli@gmail.com');               // Name is optional


    // Content
    $mail->Subject = 'Inscription sur Toraux';
    $mail->Body    = 'Merci davoir choisi Toraux, je vous aime frouchement mon ami.';

    $mail->send();
    echo 'Message has been sent';

      ?>