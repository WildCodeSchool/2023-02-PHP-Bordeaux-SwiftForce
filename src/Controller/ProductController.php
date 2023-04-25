<?php

namespace App\Controller;

use App\Model\ProductManager;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll('id');

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    public function sortPrice()
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productManager = new ProductManager();
            $products = $productManager->sortByPrice();

            return $this->twig->render('Product/index.html.twig', ['products' => $products]);
        }
    }

/*//////////////// fonction de verrou  ////////////////
    public function isLocked()
    {
        if (isset($_SESSION['cart']) && $_SESSION['cart']['locker']) {
            return true;
        } else {
            return false;
        }
    }

//début de la fonction addItem :
Si le panier existe et n'est pas verrouillé
        if (createCart() && !isLocked()) {
            //Si le produit existe déjà on ajoute seulement la quantité*/


    //////////////// fonction de création du panier et d'ajout ////////////////
    public function add($id)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $id = $_GET['id'];
            $productManager = new ProductManager();
            $product = $productManager->selectOneById($id);

            $productName = $product['name_product'];
            $productQuantity = 1;
            $productPrice = $product['price'];

            if (!isset($_SESSION['cart'])) {
                $_SESSION['cart'] = array();
                $_SESSION['cart']['productName'] = array();
                $_SESSION['cart']['productQuantity'] = array();
                $_SESSION['cart']['productPrice'] = array();
                $_SESSION['cart']['locker'] = false;
            }
                    //return true;
        }
            $productPosition = array_search($productName, $_SESSION['cart']['productName']);

        if ($productPosition !== false) {
                $_SESSION['cart']['productQuantity'][$productPosition] += $productQuantity;
        } else {
                //Sinon on ajoute le produit
                array_push($_SESSION['cart']['productName'], $productName);
                array_push($_SESSION['cart']['productQuantity'], $productQuantity);
                array_push($_SESSION['cart']['productPrice'], $productPrice);
        }
            header('Location:/product');
    }
}
