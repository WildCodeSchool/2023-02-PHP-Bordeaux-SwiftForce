<?php

namespace App\Controller;

use App\Model\BasketManager;
use App\Services\sendMail;

class BasketController extends AbstractController
{
    public function index(): string
    {
        if (isset($_SESSION['cart'])) {
            $total = 0;
            foreach ($_SESSION['cart'] as $cart) {
                $total += $cart['quantity'] * $cart['price'];
            }
        } else {
            $total = 0;
        }
        return $this->twig->render('basket/index.html.twig');
    }

    //////////////// fonction de suppression d'un article du panier ////////////////
    public function delete($id)
    {
        if (!isset($id)) {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                $id = $_GET['id'];
            }
        }
        $key = 'product_' . $id;
        unset($_SESSION['cart'][$key]);
        if (isset($_SESSION['promotion'])) {
            $total = 0;
            foreach ($_SESSION['cart'] as $cart) {
                $total += $cart['quantity'] * $cart['price'];
                if (isset($_SESSION['promotion']['seuil'])) {
                    if ($_SESSION['promotion']['seuil'] > $total) {
                        $manque = $_SESSION['promotion']['seuil'] - $total;
                        $_SESSION['promotionError'] = "Plus que " . $manque . " € pour utiliser le code " . $_SESSION['promotion']['name'] . ".";
                        $_SESSION['seuilOK'] = false;
                    }
                    if (str_contains($_SERVER['HTTP_REFERER'], 'basket')) {
                        header('Location:/basket');
                    }
                } else {
                    $_SESSION['promotion'] = [];
                    $_SESSION['promotionError'] = [];
                }
            }
        }
        header('Location:' . $_SERVER['HTTP_REFERER']);
    }

    //////////////// fonction de modification d'un panier ////////////////
    public function edit($id, $quantity)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $quantity = $_GET['quantity'];
            $key = 'product_' . $id;
            if (isset($_GET['quantityChange+'])) {
                $_SESSION['cart'][$key]['quantity'] = ++$quantity;
                $_SESSION['cart'][$key]['total'] = $quantity * $_SESSION['cart'][$key]['price'];
            } elseif (isset($_GET['quantityChange-'])) {
                if ($_SESSION['cart'][$key]['quantity'] > 1) {
                    $_SESSION['cart'][$key]['quantity'] = --$quantity;
                    $_SESSION['cart'][$key]['total'] = $quantity * $_SESSION['cart'][$key]['price'];
                } else {
                    unset($_SESSION['cart'][$key]);
                    if ($_SESSION['cart'] == []) {
                        if (isset($_SESSION['promotionError'])) {
                            $_SESSION['promotionError'] = "";
                            $_SESSION['promotion'] = [];
                        }
                    }
                }
            }
            if (isset($_SESSION['promotion'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $cart) {
                    $total += $cart['quantity'] * $cart['price'];
                    if (isset($_SESSION['promotion']['seuil'])) {
                        if ($_SESSION['promotion']['seuil'] > $total) {
                            $manque = $_SESSION['promotion']['seuil'] - $total;
                            $_SESSION['promotionError'] = "Plus que " . $manque . " € pour utiliser le code " . $_SESSION['promotion']['name'] . ".";
                            $_SESSION['seuilOK'] = false;
                        } else {
                            $_SESSION['reduction'] = $_SESSION['promotion']['reduction'];
                            $errors['promo'] = "";
                            $_SESSION['promotionError'] = $errors['promo'];
                            $_SESSION['seuilOK'] = true;
                        }
                    } else {
                        $_SESSION['promotionError'] = "";
                        $_SESSION['promotion'] = [];
                    }
                    if (str_contains($_SERVER['HTTP_REFERER'], 'basket')) {
                        header('Location:/basket');
                    }
                }
            }
        } else {
            echo "Un problème est survenu veuillez contacter l'administrateur du site.";
        }
        header('Location:/basket');
    }

    //////////////// fonction de validation du panier ////////////////
    public function validation()
    {
        if (!isset($_SESSION['user_id'])) {
            header('Location:/login');
        } else {
            $format = 'Y-m-d H:i:s';
            $date = gmdate($format);
            //$date = time();
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['validation']) && $_GET['validation'] === 'ok') {
                    if (!empty($_SESSION['cart'])) {
                        $basket = $_SESSION['cart'];
                        $orderGeneral = [
                            'userID' => $_SESSION['user_id'],
                            'orderDate' => $date,
                            'shipping' => 40,
                            'total' => $_SESSION['total']
                        ];
                        //////////////// insertion dans la BDD de la commande globale ////////////////
                        $orderManager = new BasketManager();
                        $orderID = $orderManager->insertOrderGeneral($orderGeneral);
                        //////////////// insertion dans la BDD du contenu de la commande ////////////////
                        $orderManager = new BasketManager();
                        $order = $orderManager->insertOrderContent($basket, $orderID);
                        //////////////// vidage du panier virtuel ////////////////
                        unset($_SESSION['cart']);
                        //////////////// envoi du mail de confirmation ////////////////
                        $mail = new sendMail();
                        $mail->sendmail('contact@thewildshop.com', 'The Wild Shop', $_SESSION['user']['email'], $_SESSION['user']['user_name'], 'Votre commande', "Merci d'avoir choisi The Wild Shop. Nous vous informerons de l'expédition de votre commande.");
                        header('Location:/profile/orders');
                    }
                }
            }
        }
    }
    public function promotion($codeName)
    {
        $errors['promo'] = $_SESSION['reduction'] = "";
        function checkdata($data)
        {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = htmlentities($data);
            return $data;
        }

        if (!isset($_SESSION['user_id'])) {
            header('Location:/login');
        } else {
            if ($_SERVER['REQUEST_METHOD'] === 'GET') {
                if (isset($_GET['promo'])) {
                    if (empty(trim($_GET['codeName']))) {
                        $errors['promo'] = "Merci de saisir un code.";
                        $_SESSION['promotionError'] = $errors['promo'];
                        $_SESSION['promotion'] = [];
                    } elseif (!isset($_SESSION['cart'])) {
                        $errors['promo'] = "Votre panier est vide.";
                        $_SESSION['promotionError'] = $errors['promo'];
                        $_SESSION['promotion'] = [];
                    } else {
                        $codeName = checkdata($_GET['codeName']);
                        $codeName = strtoupper($codeName);
                        $basketManager = new BasketManager();
                        $promotion = $basketManager->promotion($codeName);
                        if ($promotion != false) {
                            if ($promotion['seuil'] > $_SESSION['total']){
                                $manque = $promotion['seuil'] - $_SESSION['total'];
                                $_SESSION['promotion'] = $promotion;
                                $_SESSION['seuilOK'] = false;
                                $errors['promo'] = "Plus que ". $manque . "€ pour utiliser le code " . $_SESSION['promotion']['name'] . ".";
                                $_SESSION['promotionError'] = $errors['promo'];
                            } else {
                                $_SESSION['promotion'] = $promotion;
                                $errors['promo'] = "";
                                $_SESSION['promotionError'] = $errors['promo'];
                                $_SESSION['seuilOK'] = true;
                            }
                        } else {
                            $errors['promo'] = "Ce code n'est pas valide.";
                            $_SESSION['promotionError'] = $errors['promo'];
                            $_SESSION['promotion'] = [];
                        }
                    }
                }
                header('Location:/basket');
            } else {
                header('Location:' . $_SERVER['HTTP_REFERER']);
            }
        }
    }
}
