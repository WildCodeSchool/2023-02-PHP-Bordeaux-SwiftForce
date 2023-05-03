<?php

namespace App\Controller;

use App\Model\UserManager;

class LoginController extends AbstractController
{
    public function login()
{
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $userManager = new UserManager();
        $email = $_POST['email'];
        $user = $userManager->getUserByEmail($email);
        $_SESSION['user'] = $user;

        if ($_POST['email'] === $user['email'] && password_verify($_POST['WS_password'], $user['WS_password'])) {
            $_SESSION['user_id'] = $user['id'];
            header('Location: /');
        } else {
            echo 'Désolé vous n\'étes pas inscrit';
        }
    }
    return $this->twig->render('login/login.html.twig');
}

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        header('location: /');
    }
}
