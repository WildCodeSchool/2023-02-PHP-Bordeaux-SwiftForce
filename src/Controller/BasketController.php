<?php

namespace App\Controller;

class BasketController extends AbstractController
{
    public function index(): string
    {
        $total = 0;
        foreach ($_SESSION['cart'] as $cart) {
            $total += $cart['quantity'] * $cart['price'];
        }
        $totalLivraison = $total + 40;
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
        header('Location:/basket');
    }

    //////////////// fonction de modification d'un panier ////////////////
    public function edit($id, $quantity)
    {
        if (($_SERVER['REQUEST_METHOD'] === 'GET') && (isset($_GET['quantityChange']))) {
            $id = $_GET['id'];
            $quantity = $_GET['quantity'];
            $key = 'product_' . $id;
            //Si la quantité est positive on modifie sinon on supprime l'article
            if ($quantity > 0) {
                $_SESSION['cart'][$key]['quantity'] = $quantity;
            } else {
                unset($_SESSION['cart'][$key]);
            }
        } else {
            echo "Un problème est survenu veuillez contacter l'administrateur du site.";
        }
        header('Location:/basket');
    }
}
