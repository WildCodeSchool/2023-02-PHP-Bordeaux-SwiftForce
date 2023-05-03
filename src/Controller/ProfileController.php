<?php

namespace App\Controller;

class ProfileController extends AbstractController
{
    public function view()
    {
        $user = $_SESSION['user'];

        return $this->twig->render('profile/view.html.twig', ['user' => $user]);
    }

    public function orders()
    {

        return $this->twig->render('profile/order.html.twig');
    }
}
