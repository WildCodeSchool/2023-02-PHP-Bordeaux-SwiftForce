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

    public function sortPrice(string $price): string
    {
        $productManager = new ProductManager();
        $products = $productManager->sortByPrice($price);

        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $price = $_GET['price'];
            header('Location:/product/sort?price=' . $price);
        }
        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }

    public function sortSubCategory(string $subCat): string
    {
        $productManager = new ProductManager();
        $products = $productManager->sortBySubCategory($subCat);

        if ($_SERVER['REQUEST_METHOD'] === 'get') {
            $subCat = $_GET['name_sub_category'];
            header('Location:/product/sort?=' . $subCat);
        }

        return $this->twig->render('Product/index.html.twig', ['products' => $products]);
    }
}
