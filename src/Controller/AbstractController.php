<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;


require 'vendor/autoload.php';

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array | false $user;

    public function __construct()
    {
        $loader = new FilesystemLoader(APP_VIEW_PATH);
        $this->twig = new Environment(
            $loader,
            [
                'cache' => false,
                'debug' => true,
            ]
        );
        $this->twig->addExtension(new DebugExtension());

        $userManager = new UserManager();
        $this->user = isset($_SESSION['user_id']) ? $userManager->selectOneById($_SESSION['user_id']) : false;

        $this->twig->addGlobal('user', $this->user);

        if (isset($_SESSION['cart'])) {

            $cartInvert = array_reverse($_SESSION['cart']);
            $total = "0";
            foreach ($_SESSION['cart'] as $cart) {
                $total += $cart['quantity'] * $cart['price'];
            }
            $this->twig->addGlobal('carts', $cartInvert);
            $this->twig->addGlobal('total', $total);
        }
    }
}
