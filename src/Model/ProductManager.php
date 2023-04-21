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
}
