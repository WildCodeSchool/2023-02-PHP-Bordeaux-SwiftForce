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

    /*public function sortGlobal(string $catName, string $subCatName, string $price)
    {
        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $catName = $_GET['name_category'];
            $subCatName = $_GET['name_sub_category'];
            $price = $_GET['price'];

            if (!array_key_exists('name_sub_category', $_SESSION['filter'])) {
                $_SESSION['filter']['name_sub_category'] = 'default';
            }
            if (!array_key_exists('name_category', $_SESSION['filter'])) {
                $_SESSION['filter']['name_category'] = 'default';
            }
            if (!array_key_exists('price', $_SESSION['filter'])) {
                $_SESSION['filter']['price'] = 'default';
            }
            if (isset($_GET['name_sub_category'])) {
                $_SESSION['filter']['name_sub_category'] = $_GET['name_sub_category'];
            } elseif (isset($_GET['name_category'])) {
                $_SESSION['filter']['name_category'] = $_GET['name_category'];
            } elseif (isset($_GET['price'])) {
                $_SESSION['filter']['price'] = $_GET['price'];
            }
        }
        $subCatName = $_SESSION['filter']['name_sub_category'];
        $catName = $_SESSION['filter']['name_category'];
        $price = $_SESSION['filter']['price'];
        $productManager = new ProductManager();
        $products = $productManager->sortGlobal($subCatName, $catName, $price);
        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }*/

    public function show(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        return $this->twig->render('product/show.html.twig', ['product' => $product]);
    }

    public function sortPrice(string $price): string
    {
        if (isset($_SESSION['filter']['name_sub_category'])) {
            $subCat = $_SESSION['filter']['name_sub_category'];
        } else {
            $subCat = "default";
        }
        $productManager = new ProductManager();
        $products = $productManager->sortGlobal($subCat, $price);

        if (!key_exists('filter', $_SESSION)) {
            $_SESSION['filter']['price'] = "default";
        } else {
            $_SESSION['filter']['price'] = $price;
        }
        if (!key_exists('filter', $_SESSION)) {
            $_SESSION['filter']['name_sub_category'] = "default";
        }
        $filter = $_SESSION['filter'];
        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $price = $_GET['price'];
            header('Location:/product/sort?price=' . $price);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products, 'filter' => $filter, 'subCat' => $subCat]);
    }

    public function sortSubCategory(string $subCat): string
    {
        if (isset($_SESSION['filter']['price'])) {
            $price = $_SESSION['filter']['price'];
        } else {
            $price = "default";
        }
        $productManager = new ProductManager();
        $products = $productManager->sortGlobal($subCat, $price);

        if (!key_exists('filter', $_SESSION)) {
            $_SESSION['filter']['name_sub_category'] = "default";
        } else {
            $_SESSION['filter']['name_sub_category'] = $subCat;
        }
        if (!key_exists('price', $_SESSION['filter'])) {
            $_SESSION['filter']['price'] = "default";
        }
        $filter = $_SESSION['filter'];
        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $subCat = $_GET['name_sub_category'];
            header('Location:/product/sort?=' . $subCat);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products, 'filter' => $filter, 'subCat' => $subCat]);
    }

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
