<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'WS_product';

    public function sortGlobal(string $catName, string $price): bool|array
    {
        if ($catName === "default") {
            if ($price === "default") {
                $sql = "SELECT * FROM WS_product";
            } else {
                $sql = "SELECT * FROM WS_product ORDER BY price " . $price ;
            }
        } else {
            if ($price === "default") {
                $sql = "SELECT * FROM WS_product JOIN WS_sub_category
    ON WS_product.sub_category_id = WS_sub_category.id
         WHERE name_sub_category like '$catName'";
            } else {
                $sql = "SELECT * FROM WS_product JOIN WS_sub_category
    ON WS_product.sub_category_id = WS_sub_category.id
         WHERE name_sub_category like '$catName' ORDER BY price " . $price ;
            }
        }
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

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

    public function selectOneById(int $id): array|false
    {
        // prepared request
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetch();
    }
}
