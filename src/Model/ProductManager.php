<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'WS_product';

    public function sortByPrice(string $price): bool|array
    {
        $sql = "SELECT * FROM WS_product ORDER BY " . $price;
        $stm = $this->pdo->prepare($sql);
        /* $stm->bindValue('price', $price,/PDO::PARAM_STR);*/
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

    public function sortBySubCategory(string $subCat): bool|array
    {
        $sql = "SELECT * FROM WS_product JOIN WS_sub_category ON WS_product .sub_category_id = WS_sub_category.id
            WHERE name_sub_category like '$subCat'";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }
}
