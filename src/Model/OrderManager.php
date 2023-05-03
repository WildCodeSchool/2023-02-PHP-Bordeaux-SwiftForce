<?php

namespace App\Model;

class OrderManager extends AbstractManager
{
    public const TABLE = 'ws_orders';

    public function selectAllById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE user_id=:id ORDER BY order_date");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }
    public function selectOrderById(int $id): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM ws_order_content WHERE order_id=:id");
        $statement->bindValue('id', $id, \PDO::PARAM_INT);
        $statement->execute();

        return $statement->fetchAll();
    }

}
