<?php

namespace App\Controller;

use App\Services\sendMail;

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
        $name = $email = $phone = $subject = $message = "";
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
            if (isset($_POST['txtMsg'])) {
                $message = checkdata($_POST['txtMsg']);
            }
            if ($name != "" & $email != "") {
                $mail = new sendMail();
                $mail->sendMail($email, $name, 'contact@thewildshop.com', "Service Clients", $subject, $message . $phone);
                return $this->twig->render('Home/contact/envoi.html.twig', ['name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message]);
            }
        }
        return $this->twig->render('Home/contact.html.twig', ['errorName' => $errors['name'], 'errorEmail' => $errors['email'], 'name' => $name, 'email' => $email, 'phone' => $phone, 'subject' => $subject, 'message' => $message]);
    }
    public function blog($id): string
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];

            /*switch ('id') {
                case 1:
                    return $this->twig->render('Home/blog1.html.twig');
                    break;
                case 2:
                    return $this->twig->render('Home/blog2.html.twig');
                    break;
                case 3:
                    return $this->twig->render('Home/blog3.html.twig');
                    break;
                case 4:
                    return $this->twig->render('Home/blog4.html.twig');
                    break;
            }*/
        }
        return $this->twig->render('Home/blog1.html.twig', ['id' => $id]);
    }
}
