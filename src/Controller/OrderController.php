<?php

namespace App\Controller;

use App\Model\OrderManager;

class OrderController extends AbstractController
{
    public function index()
    {
        $orderManager = new OrderManager();
        $orders = $orderManager->selectAllById($_SESSION['user_id']);
        return $this->twig->render('profile/order.html.twig', ['orders' => $orders]);
    }
    public function show(int $id): string
    {
        $orderManager = new OrderManager();
        $order = $orderManager->selectOrderById($id);
        return $this->twig->render('profile/order/show.html.twig', ['order' => $order]);
    }
}
