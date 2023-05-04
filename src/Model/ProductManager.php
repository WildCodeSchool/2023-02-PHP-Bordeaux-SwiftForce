<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'WS_product';
    public function getAll(): bool|array
    {
        $sql = "SELECT * FROM WS_product";
        $stm = $this->pdo->prepare($sql);
        $stm->execute();
        return $stm->fetchAll(PDO::FETCH_ASSOC);
    }

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

    ON WS_product.sub_category_id_cat = WS_sub_category.id_cat
         WHERE name_sub_category like '$catName'";
            } else {
                $sql = "SELECT * FROM WS_product JOIN WS_sub_category
    ON WS_product.sub_category_id_cat = WS_sub_category.id_cat

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
        $sql = "SELECT * FROM WS_product JOIN WS_sub_category ON WS_product .sub_category_id_cat = WS_sub_category.id_cat

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
    public function addProduct(array $product, array $file): int
    {
        $statement = $this->pdo->prepare("INSERT INTO " . self::TABLE . " (sub_category_id_cat, name_product, price, description, image) VALUES (:sub_category_id_cat, :name_product, :price, :description, :image)");
        $statement->bindValue('sub_category_id_cat', $product['sub_category_id_cat'], PDO::PARAM_INT);
        $statement->bindValue('name_product', $product['name_product'], PDO::PARAM_STR);
        $statement->bindValue('price', $product['price'], PDO::PARAM_INT);
        $statement->bindValue('description', $product['description'], PDO::PARAM_STR);
        $statement->bindValue('image', $file['image']['name'], PDO::PARAM_STR);

        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }

    public function editProduct(array $product): bool
    {
        $sql = "UPDATE " . self::TABLE . " SET
                   `name_product` = :name_product,
                   `price` = :price,
                   `description` = :description,
                   `sub_category_id_cat` = :sub_category_id_cat
                   WHERE id =:id";
        $stm = $this->pdo->prepare($sql);
        $stm->bindValue(':name_product', $product['name_product'], PDO::PARAM_STR);
        $stm->bindValue(':price', $product['price'], PDO::PARAM_INT);
        $stm->bindValue(':description', $product['description'], PDO::PARAM_STR);
        $stm->bindValue(':sub_category_id_cat', $product['sub_category_id_cat'], PDO::PARAM_STR);
        $stm->bindValue(':id', $product['id'], PDO::PARAM_INT);

        return $stm->execute();
    }
}
