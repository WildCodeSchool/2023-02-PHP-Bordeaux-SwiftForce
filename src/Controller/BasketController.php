<?php

namespace App\Controller;

class BasketController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('basket/index2.html.twig', []);
    }

    //////////////// fonction de suppression d'un article du panier ////////////////
    public function deleteItem($name)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $name = $_GET['productName'];
            // a voir si on utilise la même méthode quand on est déjà dans le panier

            //Si le panier existe
            if (createCart() && !isLocked()) {
                //Nous allons passer par un panier temporaire
                $tmp = array();
                $tmp['productName'] = array();
                $tmp['productQuantity'] = array();
                $tmp['productPrice'] = array();
                $tmp['locker'] = $_SESSION['cart']['locker'];

                for ($i = 0; $i < count($_SESSION['cart']['productName']); $i++) {
                    if ($_SESSION['panier']['productName'][$i] !== $name) {
                        array_push($tmp['productName'], $_SESSION['cart']['productName'][$i]);
                        array_push($tmp['productQuantity'], $_SESSION['cart']['productQuantity'][$i]);
                        array_push($tmp['productPrice'], $_SESSION['cart']['productPrice'][$i]);
                    }
                }
                //On remplace le panier en session par notre panier temporaire à jour
                $_SESSION['cart'] = $tmp;
                //On efface notre panier temporaire
                unset($tmp);
            } else {
                echo "Un problème est survenu veuillez contacter l'administrateur du site.";
            }
        }
        header('Location:/basket');
    }

    //////////////// fonction de modification d'un panier ////////////////
    public function modifyItemQuantity($productName, $productQuantity)
    {
        if (($_SERVER['REQUEST_METHOD'] === 'GET') && (isset($_GET['quantityChange']))) {
            $productName = $_GET['data']['name'];
            $productQuantity = $_GET['data']['quantity'];

            //Si le panier existe
            if (createCart() && !isLocked()) {
                //Si la quantité est positive on modifie sinon on supprime l'article
                if ($productQuantity > 0) {
                    //Recherche du produit dans le panier
                    $productPosition = array_search($productName, $_SESSION['cart']['productName']);

                    if ($productPosition !== false) {
                        $_SESSION['cart']['productQuantity'][$productPosition] = $productQuantity;
                    } else {
                        deleteItem($productName);
                    }
                } else {
                        echo "Un problème est survenu veuillez contacter l'administrateur du site.";
                }
            }
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
