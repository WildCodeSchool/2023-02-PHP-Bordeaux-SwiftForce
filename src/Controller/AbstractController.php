<?php

namespace App\Controller;

use App\Model\UserManager;
use Twig\Environment;
use Twig\Extension\DebugExtension;
use Twig\Loader\FilesystemLoader;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

/**
 * Initialized some Controller common features (Twig...)
 */
abstract class AbstractController
{
    protected Environment $twig;
    protected array|false $user;

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
            $totalAvantRemise = 0;
            foreach ($_SESSION['cart'] as $cart) {
                $totalAvantRemise += $cart['quantity'] * $cart['price'];
            }
            $_SESSION['total'] = $totalAvantRemise;

            $totalApresRemise = 0;
            $promo = 0;
            $promotion = "";
            $remise = "";
            if ($_SESSION['promotion'] != ''){
                $promo = $_SESSION['promotion'];
                $promotion = $promo . '%';
                $remise = 'Remise';
            }
            if ($promo = 0){
                $totalApresRemise = $totalAvantRemise;
            } else {
                $totalApresRemise = $totalAvantRemise * (1 - ($promo / 100));
            }

            $ports = 4.99;
            /*if (isset($_SESSION['promo'])){
                $ports = $_SESSION['promo'];
            }*/
            $totalApresRemise = $totalApresRemise + $ports;
            $totalApresRemise = round($totalApresRemise, 2);

            $errorPromotion = "";
            if (isset($_SESSION['promotionError'])){
                $errorPromotion = $_SESSION['promotionError'];
            }

            $this->twig->addGlobal('carts', $cartInvert);
            $this->twig->addGlobal('ports', $ports);
            $this->twig->addGlobal('promotion', $promotion);
            $this->twig->addGlobal('remise', $remise);
            $this->twig->addGlobal('total', $totalAvantRemise);
            $this->twig->addGlobal('totalTTC', $totalApresRemise);
            $this->twig->addGlobal('errorPromotion', $errorPromotion);

        }
    }
}
