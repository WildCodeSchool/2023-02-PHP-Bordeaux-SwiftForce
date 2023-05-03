<?php

namespace App\Controller;

use App\Model\UserManager;

class ProfileController extends AbstractController
{
    public function view()
    {
        $user = $_SESSION['user'];
        return $this->twig->render('profile/view.html.twig', ['user' => $user]);
    }
}
