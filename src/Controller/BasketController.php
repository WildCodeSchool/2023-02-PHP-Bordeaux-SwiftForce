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
            $totalLivraison = $total + 40;
        } else {
            $total = 0;
            $totalLivraison = $total + 40;
        }
        return $this->twig->render('basket/index.html.twig', ['total' => $total, 'totalLivraison' => $totalLivraison]);
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
