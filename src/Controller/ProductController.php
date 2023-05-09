<?php

namespace App\Controller;

use App\Model\ProductManager;
use App\services\Fixtures;
use PDO;
use Symfony\Component\DependencyInjection\Tests\Compiler\Locator;

class ProductController extends AbstractController
{
    public function index(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll('id');

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    public function show(int $id): string
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);
        if (isset($_SESSION['filter'])){
            $filter = $_SESSION['filter'];
        } else {
            $filter = [];
        }
        switch ($product['sub_category_id_cat']) {
            case '1':
                $filter['name_sub_category'] = "get_dressed";
                break;
            case '2':
                $filter['name_sub_category'] = "to_eat";
                break;
            case '3':
                $filter['name_sub_category'] = "take_shelter";
                break;
            case '4':
                $filter['name_sub_category'] = "to_defend";
                break;
            case '5':
                $filter['name_sub_category'] = "orientation";
                break;
            case '6':
                $filter['name_sub_category'] = "survival_kit";
                break;
        }
        switch ($filter['name_sub_category']) {
            case 'get_dressed':
                $catNameFrench = "S'habiller";
                break;
            case 'to_eat':
                $catNameFrench = 'Se nourrir';
                break;
            case 'take_shelter':
                $catNameFrench = "S'abriter";
                break;
            case 'to_defend':
                $catNameFrench = "Se défendre";
                break;
            case 'orientation':
                $catNameFrench = "S'orienter";
                break;
            case 'survival_kit':
                $catNameFrench = "Kits de survie";
                break;
        }
        return $this->twig->render('product/show.html.twig', ['product' => $product, 'filter' => $filter, 'catNameFrench' => $catNameFrench]);
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
        if (strpos($_SERVER['REQUEST_URI'], 'sortCat?')) {
            $name = explode("cat=", $_SERVER['REQUEST_URI']);
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
            if (isset($_SESSION['promotion'])) {
                $total = 0;
                foreach ($_SESSION['cart'] as $cart) {
                    $total += $cart['quantity'] * $cart['price'];
                    if (isset($_SESSION['promotion']['seuil'])){
                        if ($_SESSION['promotion']['seuil'] > $total) {
                            $manque = $_SESSION['promotion']['seuil'] - $total;
                            $_SESSION['promotionError'] = "Plus que " . $manque . " € pour utiliser le code " . $_SESSION['promotion']['name'] . ".";
                            $_SESSION['seuilOK'] = false;
                        } else {
                            $_SESSION['reduction'] = $_SESSION['promotion']['reduction'];
                            $_SESSION['promotionError'] = "";
                            $_SESSION['seuilOK'] = true;
                        }
                    }
                    if (str_contains($_SERVER['HTTP_REFERER'], 'basket')) {
                        header('Location:/basket');
                    }
                }
            }
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }
    }

    public function addProd(): string
    {
        $product['name'] = $product['sub_cat'] = $product['price'] = $product['description'] = $product['image'] = "";
        $errors['name'] = $errors['sub_cat'] = $errors['price'] = $errors['description'] = $errors['image'] = "";
        function checkdata($data)
        {
            $data = trim($data);
            $data = htmlspecialchars($data);
            $data = htmlentities($data);
            return $data;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $uploadDir = "../public/assets/images/";
            $extension = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
            $uploadFile = $uploadDir . $_FILES['image']['name'];
            move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile);
            $authorizedExtensions = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            $maxFileSize = 1000000;

            if ((!in_array($extension, $authorizedExtensions))) {
                $errors['image'] = 'Veuillez sélectionner une image de type Jpg ou Jpeg ou PNG ou gif ou webp.';
            }
            if (file_exists($_FILES['image']['name']) && filesize($_FILES['image']['tmp_name']) > $maxFileSize) {
                $errors['image'] = 'Voter fichier doit faire moins de 1Mo.';
            }
            if ($_POST['sub_category_id_cat'] === '') {
                $errors['sub_cat'] = 'Merci de choisir une sous-catégorie.';
            } else {
                $product['sub_cat'] = checkdata($_POST['sub_category_id_cat']);
            }
            if (!isset($_POST['name_product']) | empty(trim($_POST['name_product']))) {
                $errors['name'] = 'Ce champs est obligatoire.';
            } else {
                $product['name'] = checkdata($_POST['name_product']);
            }
            if (!isset($_POST['price']) | empty(trim($_POST['price']))) {
                $errors['price'] = 'Ce champs est obligatoire.';
            } else {
                $product['price'] = checkdata($_POST['price']);
            }
            if (!isset($_POST['description']) | empty(trim($_POST['description']))) {
                $errors['description'] = 'Ce champs est obligatoire.';
            } else {
                $product['description'] = checkdata($_POST['description']);
            }
            if ($errors['name'] != "" | $errors['sub_cat'] != "" | $errors['price'] != "" | $errors['description']  != "" | $errors['image'] != "") {
                return $this->twig->render('product/addProduct.html.twig', ['error' => $errors, 'product' => $product]);
            } else {
                $productManager = new productManager();
                $productManager->addProduct($_POST, $_FILES);
                header('Location:/product/showAll');
            }
        }
        return $this->twig->render('product/addProduct.html.twig', ['error' => $errors, 'product' => $product]);
    }

    public function showAll(): string
    {
        $productManager = new ProductManager();
        $products = $productManager->selectAll();
        $products = array_reverse($products);

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

    public function productFixtures(): string
    {
        $productManager = new Fixtures();
        $product = $productManager->getProductFixtures(1);

        return $this->twig->render('product/fakerProduct.html.twig', [
            'product' => $product,
        ]);
    }

    public function pagination(): string
    {
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $currentPage = (int)strip_tags($_GET['page']);
        } else {
            $currentPage = 1;
        }
        $productManager = new ProductManager();
        $nbProducts = $productManager->countProduct();

        $parPage = 12;

        $pages = ceil($nbProducts / $parPage);

        $premier = ($currentPage * $parPage) - $parPage;

        $products = $productManager->getProduct($premier, $parPage);

        return $this->twig->render('product/index.html.twig',['products' => $products, 'page' => $pages]);
    }
}
