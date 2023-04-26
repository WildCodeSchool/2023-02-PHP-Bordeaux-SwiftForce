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

/*
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
            $productImage = $product['image'];
            $productID = $id;
            $key = "product_" . $id;

            if (isset($_SESSION['cart'])) {
                if (array_key_exists($key, $_SESSION['cart'])) {
                    $_SESSION['cart']['product_' . $id]['quantity'] += $productQuantity;
                } else {
                    //Sinon on ajoute le produit
                    $_SESSION['cart']['product_' . $id] = [
                        'name' => $productName,
                        'quantity' => $productQuantity,
                        'price' => $productPrice,
                        'image' => $productImage,
                        'id' => $productID,
                        'total' => $productQuantity * $productPrice
                    ];
                }
            } else {
                //Sinon on ajoute le produit
                $_SESSION['cart']['product_' . $id] = [
                    'name' => $productName,
                    'quantity' => $productQuantity,
                    'price' => $productPrice,
                    'image' => $productImage,
                    'id' => $productID,
                    'total' => $productQuantity * $productPrice
                ];
            }
            header('Location:/product');
        }
    }
}
