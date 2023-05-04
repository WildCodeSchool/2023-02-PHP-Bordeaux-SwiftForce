<?php

namespace App\Services;

use App\Model\AbstractManager;
use App\Model\ProductManager;
use Faker;

class Fixtures extends AbstractManager
{
    private const images= [
        'nuage.png',
    ];


    public function getProductFixtures(int $numberOfProduct): void
    {
        $faker = Faker\Factory::create('fr_FR');
        $product = [];
        $userManager = new ProductManager();
        for ($i = 0; $i <= $numberOfProduct; $i++) {
            $product['sub_category_id_cat'] = $faker->numberBetween(1, 6);
            $product['name_product'] = $faker->unique()->sentence(3);
            $product['price'] = $faker->randomFloat(2, 5, 500);
            $product['description'] = $faker->paragraph(3);
            $product['image'] = rand(self::images);

            $userManager->addProductFaker($product);
        }
    }
}
