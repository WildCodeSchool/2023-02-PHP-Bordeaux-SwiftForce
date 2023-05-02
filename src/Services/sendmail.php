<?php

namespace App\Services;

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

class sendMail
{
    function sendmail(string $from, string $fromName, string $to, string $toName, string $subject, string $message)
    {
        $mail = new PHPMailer(true);
        //$mail->SMTPDebug = SMTP::DEBUG_SERVER;               //Enable verbose debug output
        $mail->isSMTP();                                     //Send using SMTP
        $mail->Host       = 'localhost';                     //Set the SMTP server to send through
        //$mail->SMTPAuth   = true;                            //Enable SMTP authentication
        //$mail->Username   = 'user@example.com';              //SMTP username
        //$mail->Password   = 'secret';                        //SMTP password
        //$mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;     //Enable implicit TLS encryption
        $mail->Port       = 1025;                            //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

    //Recipients
        $mail->setFrom($from, $fromName);
        $mail->addAddress($to, $toName);     //Add a recipient
        //$mail->addAddress('ellen@example.com');               //Name is optional
        //$mail->addReplyTo('info@example.com', 'Information');
        //$mail->addCC('cc@example.com');
        //$mail->addBCC('bcc@example.com');

    //Attachments
        //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
        //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

    //Content
        $mail->isHTML(true);                                  //Set email format to HTML
        $mail->Subject = $subject;
        $mail->Body    = $message;
        $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

        $mail->send();
}
}
