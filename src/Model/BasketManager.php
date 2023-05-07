<?php

namespace App\Model;

use PDO;

class BasketManager extends AbstractManager
{
    public function insertOrderGeneral(array $orderGeneral)
    {
        $statement = $this->pdo->prepare("INSERT INTO ws_orders (user_ID, order_date, shipping, total) VALUES (:userID, :orderDate, :shipping, :total)");
        $statement->bindValue('userID', $orderGeneral['userID'], PDO::PARAM_INT);
        $statement->bindValue('orderDate', $orderGeneral['orderDate'], PDO::PARAM_STR);
        $statement->bindValue('shipping', $orderGeneral['shipping'], PDO::PARAM_INT);
        $statement->bindValue('total', $orderGeneral['total'], PDO::PARAM_INT);
        $statement->execute();
        return (int)$this->pdo->lastInsertId();
    }
    public function insertOrderContent(array $basket, $id)
    {
        foreach ($basket as $product) {
            $statement = $this->pdo->prepare("INSERT INTO ws_order_content (order_id, product_id, name_product, product_quantity, price_per) VALUES (:order_id, :product_id, :name_product, :product_quantity, :price_per)");
            $statement->bindValue('order_id', $id, PDO::PARAM_INT);
            $statement->bindValue('product_id', $product['id'], PDO::PARAM_INT);
            $statement->bindValue('name_product', $product['name'], PDO::PARAM_STR);
            $statement->bindValue('product_quantity', $product['quantity'], PDO::PARAM_INT);
            $statement->bindValue('price_per', $product['price'], PDO::PARAM_INT);
            $statement->execute();
        }
    }
    public function promotion(string $codeName): array | bool
    {
        $statement = $this->pdo->prepare("SELECT * FROM ws_promotions WHERE name=:name");
        $statement->bindValue('name', $codeName, \PDO::PARAM_STR);
        $statement->execute();
        return $statement->fetch();
    }
}
