<?php

namespace App\Services;

use GrumPHP\Util\Str;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class StripePayment
{
    public function __construct(readonly private string $clientSecret)
    {
        Stripe::setApiKey($this->clientSecret);
        Stripe::setApiVersion('2022-11-15');
    }
    public function startPayment($total)
    {
        $session = Session::create([
            'success_url' => 'http://localhost:8000/profile/orders',
            'line_items' => [
                    'quantity' => 1,
                    'price' => $total
                ],
            'mode' => 'payment'
        ]);
        header('Location:' . $session->url);
    }


    /*
     *  $session = Session::create([
            'success_url' => 'http://localhost:8000/profile/orders',
            'line_items' => [
                array_map(fn (array $product) => [
                    'quantity' => $product['quantity'],
                    'price_data' => [
                        'currency' => 'EUR',
                        'product_data' => [
                            'name' => $product['name']
                        ],
                        'unit_amount' => $product['price']
                    ]
        ], $panier)
        ],
            'mode' => 'payment',
        ]);
        header('Location:' . $session->url);
     */
}
