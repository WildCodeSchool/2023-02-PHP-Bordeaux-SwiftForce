<?php

namespace App\Controller;

use App\Model\ProductManager;
use PDO;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll('id');

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    /* fonction pour appliquer les filtres en même temps à développer
     public function sortGlobal(string $catName, string $subCatName, string $price)
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
        $filter = $_SESSION['filter'];

        return $this->twig->render('product/show.html.twig', ['product' => $product, 'filter' => $filter]);
    }

    public function sortPrice(string $price): string
    {
        if (isset($_SESSION['filter']['name_sub_category'])) {
            $subCat = $_SESSION['filter']['name_sub_category'];
            if (strpos($_SERVER['HTTP_REFERER'], 'sortCat')) {
                $name = explode("=", $_SERVER['HTTP_REFERER']);
                $name = $name[1];
                $_SESSION['filter']['name'] = $name;
                $subCat = "default";
            } else {
                if (!in_array('water' | 'fire' | 'chemical' | 'exterior' | 'wind' | 'earth', $_SESSION['filter'])) {
                    $subCat = $_SESSION['filter']['name_sub_category'];
                }
            }
        } else {
            $subCat = "default";
        }
        $productManager = new ProductManager();
        $products = $productManager->sortGlobal($subCat, $price);
        $filter = $_SESSION['filter'];
        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $price = $_GET['price'];
            header('Location: /product/sort?price=' . $price);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products, 'filter' => $filter, 'subCat' => $subCat]);
    }

    public function sortSubCategory(string $subCat): string
    {
        $name = explode("=", $_SERVER['REQUEST_URI']);
        $name = $name[1];
        $_SESSION['filter']['name'] = $name;

        if (isset($_SESSION['filter']['price'])) {
            $price = $_SESSION['filter']['price'];
        } else {
            $price = "default";
        }
        $productManager = new ProductManager();
        $products = $productManager->sortGlobal($subCat, $price);

        //$_SESSION['filter']['name'] = $subCat;


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
            header('Location: /product/sort?=' . $subCat);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products, 'filter' => $filter, 'subCat' => $subCat]);
    }
    public function sortCategory(string $cat): string
    {
        if (strpos($_SERVER['REQUEST_URI'], 'sortCat?cat=')) {
            $name = explode("=", $_SERVER['REQUEST_URI']);
            $name = $name[1];
            $_SESSION['filter']['name'] = $name;
        }
        $productManager = new ProductManager();
        $products = $productManager->getAll();
        $filter = $_SESSION['filter'];

        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $cat = $_GET['cat'];
            $_SESSION['filter']['name'] = $cat;
            header('Location: /product/sortCat?cat=' . $cat);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products, 'filter' => $filter]);
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
            $productDescription = $product['description'];
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
                        'description' => $productDescription,
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
                    'description' => $productDescription,
                    'total' => $productQuantity * $productPrice
                ];
            }
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function addProd(): ?string
    {

        $errors = [];

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = "../public/assets/images/";
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
            $authorizedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $maxFileSize = 1000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $errors[] = 'Veuillez selectionner une image de type Jpg ou Jpeg ou PNG ou gif ou webp !';
            }
            if (file_exists($_FILES['image']['name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $errors[] = 'Voter fichier doit faire moins de 1M !';
            }

            if (isset($_POST['name_product']) && !empty($_POST['name_product'])) {
                $_POST['name_product'] = trim($_POST['name_product']);
                $_POST['name_product'] = htmlspecialchars($_POST['name_product']);
            } else {
                $errors [] = 'il manque le nom';
            }
            if (isset($_POST['price']) && !empty($_POST['price'])) {
                $_POST['price'] = trim($_POST['price']);
                $_POST['price'] = htmlspecialchars($_POST['price']);
            } else {
                $errors [] = 'il manque le prix';
            }
            if (isset($_POST['description']) && !empty($_POST['description'])) {
                $_POST['description'] = trim($_POST['description']);
                $_POST['description'] = htmlspecialchars($_POST['description']);
            } else {
                $errors [] = "il manque la description";
            }
            if (!empty($errors)) {
                return $this->twig->render('product/error.html.twig', ['errors' => $errors]);
            }


                $productManager = new productManager();
                $productManager->addProduct($_POST, $_FILES);

                header('Location:/product');
                return null;
        }

        return $this->twig->render('product/addProduct.html.twig');
    }

    public function showAll(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();

        return $this->twig->render('product/showAll.html.twig', ['products' => $products]);
    }
    public function delete(): void
    {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $id = $_POST['id'];
            $userManager = new ProductManager();
            $userManager->delete($id);
            header('Location: /product/showAll');
        }
    }

    public function edit(int $id)
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $product = array_map('trim', $_POST);

            $productManager->editproduct($product);
            header('location: /product/showAll');
        }

        return $this->twig->render('product/edit.html.twig', [
            'product' => $product,
        ]);
    }
}
