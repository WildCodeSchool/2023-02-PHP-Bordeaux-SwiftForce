<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'WS_product';

    public function sortByPrice(string $price)
    {
        $sql = "SELECT * FROM WS_product ORDER BY " . $price;
        $stm = $this->pdo->prepare($sql);
       /* $stm->bindValue('price', $price,/PDO::PARAM_STR);*/
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
