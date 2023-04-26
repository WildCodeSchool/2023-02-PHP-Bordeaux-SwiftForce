<?php

namespace App\Controller;

class BasketController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('basket/index.html.twig', []);
    }

    //////////////// fonction de suppression d'un article du panier ////////////////
    public function delete($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $key = 'product_' . $id;
            unset($_SESSION['cart'][$key]);
        }
        header('Location:/basket');
    }

    //////////////// fonction de modification d'un panier ////////////////
    public function edit($id, $quantity)
    {
        if (($_SERVER['REQUEST_METHOD'] === 'GET') && (isset($_GET['quantityChange']))) {
            echo 'test';
            $id = $_GET['id'];
            $quantity = $_GET['quantity'];
            $key = 'product_' . $id;
            //Si la quantité est positive on modifie sinon on supprime l'article
            if ($quantity > 0) {
                $_SESSION['cart'][$key]['quantity'] = $quantity;
            } else {
                delete($id);
            }
        } else {
            echo "Un problème est survenu veuillez contacter l'administrateur du site.";
        }
        header('Location:/basket');
    }
    //////////////// fonction de modification d'un panier ////////////////
    public function totalAmount()
    {
        $total = 0;
        for ($i = 0; $i < count($_SESSION['cart']['productName']); $i++) {
            $total += $_SESSION['cart']['productQuantity'][$i] * $_SESSION['cart']['productPrice'][$i];
        }
        return $total;
    }
}
