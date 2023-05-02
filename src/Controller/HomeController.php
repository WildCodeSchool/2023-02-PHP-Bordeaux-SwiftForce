<?php

namespace App\Controller;

class HomeController extends AbstractController
{
    /**
     * Display home page
     */
    public function index(): string
    {
        return $this->twig->render('Home/index.html.twig');
    }
    public function contact(): string
    {
        $name = $email = $phone = $subject = "";
        $errors['name'] = $errors['email'] = "";
        function checkdata($data)
        {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = htmlentities($data);
            return $data;
        }
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['txtName']) | empty(trim($_POST['txtName']))) {
                $errors['name'] = "Le nom est obligatoire";
            } else {
                $name = checkdata($_POST['txtName']);
            }
            if (!isset($_POST['txtEmail']) | empty(trim($_POST['txtEmail']))) {
                $errors['email'] = "L'email est obligatoire";
            } else {
                $email = checkdata($_POST['txtEmail']);
            }
            if (isset($_POST['txtPhone'])) {
                $phone = checkdata($_POST['txtPhone']);
            }
            if (isset($_POST['txtSubject'])) {
                $subject = checkdata($_POST['txtSubject']);
            }
            $message = checkdata($_POST['txtMsg']);
            $subjectGlobal = "Mail au sujet de : " . $subject . " de " . $email;
            if ($name != "" & $email != "") {
                $mail = new PHPMailer(true);
                try {
                    //Server settings
                    $mail->SMTPDebug = SMTP::DEBUG_SERVER;                      //Enable verbose debug output
                    $mail->isSMTP();                                            //Send using SMTP
                    $mail->Host       = 'smtp://   example.com';                     //Set the SMTP server to send through
                    $mail->SMTPAuth   = true;                                   //Enable SMTP authentication
                    $mail->Username   = 'user@example.com';                     //SMTP username
                    $mail->Password   = 'secret';                               //SMTP password
                    $mail->SMTPSecure = PHPMailer::ENCRYPTION_SMTPS;            //Enable implicit TLS encryption
                    $mail->Port       = 465;                                    //TCP port to connect to; use 587 if you have set `SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS`

                    //Recipients
                    $mail->setFrom('from@example.com', 'Mailer');
                    $mail->addAddress('joe@example.net', 'Joe User');     //Add a recipient
                    $mail->addAddress('ellen@example.com');               //Name is optional
                    $mail->addReplyTo('info@example.com', 'Information');
                    $mail->addCC('cc@example.com');
                    $mail->addBCC('bcc@example.com');

                    //Attachments
                    //$mail->addAttachment('/var/tmp/file.tar.gz');         //Add attachments
                    //$mail->addAttachment('/tmp/image.jpg', 'new.jpg');    //Optional name

                    //Content
                    $mail->isHTML(true);                                  //Set email format to HTML
                    $mail->Subject = 'Here is the subject';
                    $mail->Body    = 'This is the HTML message body <b>in bold!</b>';
                    $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';

                    $mail->send();
                    echo 'Message has been sent';
                } catch (Exception $e) {
                    echo "Message could not be sent. Mailer Error: {$mail->ErrorInfo}";
                }

                //mail('vduquenoy23@gmail.com', $subjectGlobal, $message);
                return $this->twig->render('Home/contact/envoi.html.twig', ['name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject]);
            }
        }
        return $this->twig->render('Home/contact.html.twig', ['errorName' => $errors['name'], 'errorEmail' => $errors['email'], 'name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject]);
    }
}
