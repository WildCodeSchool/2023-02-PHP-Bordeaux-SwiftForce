<?php

namespace App\Model;

use PDO;

class ProductManager extends AbstractManager
{
    public const TABLE = 'WS_product';

    public function sortByPrice(): bool|array
    {
        $sql = "SELECT * FROM " . self::TABLE . " ORDER BY price ASC";
        $stmt = $this->pdo->query($sql);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
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
