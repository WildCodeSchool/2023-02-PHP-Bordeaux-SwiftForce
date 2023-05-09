<?php

namespace App\Controller;

use App\Model\OrderManager;

class OrderController extends AbstractController
{
    public function index()
    {
        $orderManager = new OrderManager();
        $orders = $orderManager->selectAllById($_SESSION['user_id']);
        $orders = array_reverse($orders);

        $profilePerso = $userCatalog = $productCatalog = $wishlistCatalog = $ordersCatalog = $logout = "";
        $ordersCatalog = "using";

        return $this->twig->render('profile/order.html.twig', ['orders' => $orders, 'profilePerso' => $profilePerso, 'usersCatalog' => $userCatalog, 'productsCatalog' => $productCatalog, 'wishlistCatalog' => $wishlistCatalog, 'ordersCatalog' => $ordersCatalog, 'logout' => $logout]);

    }
    public function show(int $id): string
    {
        $orderManager = new OrderManager();
        $order = $orderManager->selectOrderById($id);

        $profilePerso = $userCatalog = $productCatalog = $wishlistCatalog = $ordersCatalog = $logout = "";
        $ordersCatalog = "using";

        return $this->twig->render('profile/order/show.html.twig', ['order' => $order, 'profilePerso' => $profilePerso, 'usersCatalog' => $userCatalog, 'productsCatalog' => $productCatalog, 'wishlistCatalog' => $wishlistCatalog, 'ordersCatalog' => $ordersCatalog, 'logout' => $logout]);
    }
}
