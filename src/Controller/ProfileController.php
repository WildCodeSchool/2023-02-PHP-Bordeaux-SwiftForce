<?php

namespace App\Controller;

use App\Model\UserManager;
use App\Services\SendMail;

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
    public function contactPromo(): void
    {
        $userManager = new UserManager();
        $customer = $userManager->selectOneById($_SESSION['user_id']);
        $customerName = $customer['user_name'];
        $customerEmail = $customer['email'];
        $mail = new sendMail();
        $mail->sendMail('contact@thewildshop.com', 'The Wild Shop', $customerEmail, $customerName, 'Offre de bienvenue', 'Profitez de 15% de remise sur votre 1ère commande avec le code : BIENVENUE. Voir conditions sur le site.');
        header('Location:/profile');
    }
}
