<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class SendMail
{
    public function sendMail(string $from, string $fromName, string $to, string $toName, string $subject, string $message): void
    {
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;               //Enable verbose debug output
        $mail->isSMTP();                                     //Send using SMTP
        $mail->Host = 'localhost';                     //Set the SMTP server to send through

        $mail->Port = 1025;
        //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

        //Recipients
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to, $toName);     //Add a recipient

        //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
    }
}
