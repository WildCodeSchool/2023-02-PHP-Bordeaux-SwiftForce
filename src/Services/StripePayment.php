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
    public function startPayment($total, $email)
    {
        $session = Session::create([
            'customer_email' => $email,
            'line_items' => [[
                'price_data' => [
                    'currency' => 'eur',
                    'unit_amount' => $total*100,
                    'product_data' => [
                        'name' => 'Total',
                    ],
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => 'http://localhost:8000/profile/orders',
            'cancel_url' => 'http://localhost:8000/',
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
