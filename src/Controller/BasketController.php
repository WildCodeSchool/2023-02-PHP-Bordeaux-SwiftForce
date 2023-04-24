<?php

namespace App\Controller;

class BasketController extends AbstractController
{
    public function index(): string
    {
        return $this->twig->render('basket/index.html.twig', []);
    }
}
