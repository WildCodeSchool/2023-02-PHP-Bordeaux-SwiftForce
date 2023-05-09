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
        $totalQuantity = 0;
        if (isset($_SESSION['cart'])) {
            $cartInvert = array_reverse($_SESSION['cart']);
            $totalAvantRemise = 0;
            foreach ($_SESSION['cart'] as $cart) {
                $totalAvantRemise += $cart['quantity'] * $cart['price'];
            }
            $_SESSION['total'] = $totalAvantRemise;

            foreach ($_SESSION['cart'] as $cart) {
                $totalQuantity += $cart['quantity'];
            }
            $_SESSION['totalQuantity'] = $totalQuantity;

            $totalApresRemise = 0;
            $reduction = 0;
            $promotion = "";
            $remise = "";
            if (isset($_SESSION['promotion'])) {
                if ($_SESSION['promotion'] != '') {
                }
                if (isset($_SESSION['promotion']['reduction'])) {
                    if (isset($_SESSION['seuilOK'])) {
                        if ($_SESSION['seuilOK']) {
                            $reduction = $_SESSION['promotion']['reduction'];
                            $promotion = $reduction . '%';
                            $remise = 'Remise';
                            $totalApresRemise = $totalAvantRemise * (1 - ($reduction / 100));
                        } else {
                            $reduction = "";
                            $promotion = "";
                            $remise = "";
                            $totalApresRemise = $totalAvantRemise;
                        }
                    }
                } else {
                    $totalApresRemise = $totalAvantRemise;
                    $promotion = "";
                    $remise = "";
                }
            }

            $ports = 4.99;

            $totalApresRemise = $totalApresRemise + $ports;
            $totalApresRemise = round($totalApresRemise, 2);
            $_SESSION['totalStripe'] = $totalApresRemise;

            $errorPromotion = "";


            if (!empty($_SESSION['promotionError'])) {
                $errorPromotion = $_SESSION['promotionError'];
            }

            if (empty($_SESSION['cart'])) {
                $errorPromotion = "";
                $promotion = "";
                $remise = "";
            }
            $this->twig->addGlobal('carts', $cartInvert);
            $this->twig->addGlobal('ports', $ports);
            $this->twig->addGlobal('promotion', $promotion);
            $this->twig->addGlobal('remise', $remise);
            $this->twig->addGlobal('total', $totalAvantRemise);
            $this->twig->addGlobal('totalTTC', $totalApresRemise);
            $this->twig->addGlobal('errorPromotion', $errorPromotion);
            $this->twig->addGlobal('totalQuantity', $totalQuantity);
        }
    }
}
