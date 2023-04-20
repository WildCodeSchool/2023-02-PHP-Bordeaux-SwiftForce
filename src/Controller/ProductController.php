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
}
