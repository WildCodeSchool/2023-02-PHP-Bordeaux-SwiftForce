<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login()
    {
        $userTab['email'] = $userTab['password'] = "";
        $errors['email'] = $errors['password'] = "";
        $user['email'] = [];
        $user['WS_password'] = [];
        function checkdata($data): string
        {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = htmlentities($data);
            return $data;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            if (!isset($_POST['email']) | empty(trim($_POST['email']))) {
                $errors['email'] = "L'email est obligatoire";
            } else {
                $userTab['email'] = checkdata($_POST['email']);
            }
            if (!isset($_POST['WS_password']) | empty(trim($_POST['WS_password']))) {
                $errors['password'] = "Le mot de passe est obligatoire";
            } else {
                $userTab['password'] = checkdata($_POST['WS_password']);
            }
            if (empty($errors['email']) && empty($errors['password'])) {
                $userManager = new UserManager();
                $email = $_POST['email'];
                $user = $userManager->getUserByEmail($email);
                $_SESSION['user'] = $user;

                if($user === false) {
                    $errors['connexion'] = "Votre email ou votre mot de passe n'est pas valide.";
                } else {

                    if ($_POST['email'] === $user['email'] && password_verify($_POST['WS_password'], $user['WS_password'])) {
                        $_SESSION['user_id'] = $user['id'];
                        header('Location: /profile');
                    } else {
                        $errors['connexion'] = "Votre email ou votre mot de passe n'est pas valide.";
                    }
                }
            }
        }
        return $this->twig->render('login/login.html.twig', ['error' => $errors, 'user' => $userTab]);
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        if (isset($_SESSION['promotion'])){
            $_SESSION['promotion'] = "";
        }
        if (isset($_SESSION['promotionError'])){
            $_SESSION['promotionError'] = "";
        }
        header('location: /');
    }
}
