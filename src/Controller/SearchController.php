<?php

namespace App\Controller;

use App\Model\ProductManager;

class SearchController extends AbstractController
{
    public function search(): string
    {
        $products = [];
        $quot = '';
        if (isset($_GET['q']) and !empty($_GET['q'])) {
            $quot = htmlspecialchars($_GET['q']);
            $productManager = new ProductManager();
            $products = $productManager->searchProduct($quot);
        }
        return $this->twig->render('search/search.html.twig', [
            'products' => $products,
            'query' => $quot,
        ]);
    }
}
