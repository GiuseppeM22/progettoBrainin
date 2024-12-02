<?php

require 'vendor/autoload.php';  // Se stai usando Composer
require '../vendor/phpmailer/phpmailer/src/PHPMailer.php';
require '../vendor/phpmailer/phpmailer/src/SMTP.php';
require '../vendor/phpmailer/phpmailer/src/Exception.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use PHPMailer\PHPMailer\SMTP;

// Funzione per inviare email con il link di conferma
function sendConfirmationEmail($userEmail, $userName, $token) {
    date_default_timezone_set('Europe/Rome');

    $mail = new PHPMailer(true);

    try {
        $mail->isSMTP();
        $mail->Host = 'smtp.gmail.com'; 
        $mail->SMTPAuth = true;
        $mail->Username = 'gz.sports010@gmail.com';  
        $mail->Password = 'oxzr drnt puqe mvzi';         
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;  
        $mail->Port = 587; 

        // Destinatario
        $mail->setFrom('gz.sports010@gmail.com', 'Giuseppe');
        $mail->addAddress($userEmail, $userName); 
        
      
        $confirmationLink = 'http://localhost:8888/progettoBrainin/backend/verifyEmail.php?token=' . $token;
        
        // Contenuto dell'email
        $mail->isHTML(true); 
        $mail->Subject = 'Conferma la tua registrazione';
        $mail->Body    = 'Ciao ' . $userName . ',<br><br>' .
                         'Grazie per esserti registrato! Per completare la registrazione, clicca sul link qui sotto per confermare la tua email:<br><br>' .
                         '<a href="' . $confirmationLink . '">Conferma la tua email</a><br><br>' .
                         'Se non hai richiesto questa registrazione, ignora pure questa email.';
                         
        // Invio email
        $mail->send();
        return 'Email di conferma inviata con successo!';
    } catch (Exception $e) {
        return "Errore nell'invio dell'email: {$mail->ErrorInfo}";
    }
}
?>
