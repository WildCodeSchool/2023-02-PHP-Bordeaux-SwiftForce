<?php

namespace App\Controller;

use App\Model\WishlistManager;
use App\Model\ProductManager;
use PDO;

class WishlistController extends AbstractController
{
    public function add(int $id): void
    {
        $productManager = new ProductManager();
        $product = $productManager->selectOneById($id);
        $productName = $product['name_product'];
        $productPrice = $product['price'];
        $productImage = $product['image'];

        if (!isset($_SESSION['user_id'])) {
            header('Location:/login');
        } else {
            $userID = $_SESSION['user_id'];
            $wishlistManager = new WishlistManager();
            $wishlistUser = $wishlistManager->selectAllById($userID);
            $productID = [];

            foreach ($wishlistUser as $product) {
                $productID[] = $product['product_id'];
            }

            if (empty($productID)) {
                $wishlistManager = new WishlistManager();
                $wishlist = $wishlistManager->wishlist($id, $productName, $productPrice, $productImage, $userID);
            } else {
                if (in_array($id, $productID)) {
                    header('Location:' . $_SERVER['HTTP_REFERER']);
                } else {
                    $wishlistManager = new WishlistManager();
                    $wishlist = $wishlistManager->wishlist($id, $productName, $productPrice, $productImage, $userID);
                }
            }
            header('Location:' . $_SERVER['HTTP_REFERER']);
        }

    }
    public function index(): string
    {
        $userID = $_SESSION['user_id'];

        $wishlistManager = new WishlistManager();
        $wishlist = $wishlistManager->selectAllById($userID);

        $profilePerso = $userCatalog = $productCatalog = $wishlistCatalog = $ordersCatalog = $logout = "";
        $wishlistCatalog = "using";

        return $this->twig->render('profile/wishlist.html.twig', ['wishlist' => $wishlist, 'profilePerso' => $profilePerso, 'usersCatalog' => $userCatalog, 'productsCatalog' => $productCatalog, 'wishlistCatalog' => $wishlistCatalog, 'ordersCatalog' => $ordersCatalog, 'logout' => $logout]);
    }
    public function deleteWishlist(int $id): void
    {
        $userID = $_SESSION['user_id'];

        if ($_SERVER['REQUEST_METHOD'] === 'GET') {
            $productID = trim($_GET['id']);
            $wishlistManager = new WishlistManager();
            $wishlistManager->deleteWishlist($userID, $productID);

            header('Location:/wishlist');
        }
    }

}
