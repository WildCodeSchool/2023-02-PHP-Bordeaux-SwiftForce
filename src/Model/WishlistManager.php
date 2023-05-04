<?php

namespace App\Model;

use PDO;

class WishlistManager extends AbstractManager
{
    public const TABLE = 'ws_wishlist';
    public function wishlist(int $id, string $productName, float $productPrice, string $productImage, int $userID)
    {
        $statement = $this->pdo->prepare("INSERT INTO " . static::TABLE . " (product_id, product_name, product_image, product_price, user_id) VALUES (:product_id, :product_name, :product_image, :product_price, :user_id)");
        $statement->bindValue('product_id', $id, PDO::PARAM_INT);
        $statement->bindValue('product_name', $productName, PDO::PARAM_STR);
        $statement->bindValue('product_image', $productImage, PDO::PARAM_STR);
        $statement->bindValue('product_price', $productPrice, PDO::PARAM_STR);
        $statement->bindValue('user_id', $userID, PDO::PARAM_INT);
        $statement->execute();
    }
    public function selectAllById(int $userID): array
    {
        $statement = $this->pdo->prepare("SELECT * FROM " . static::TABLE . " WHERE user_id=:user_id");
        $statement->bindValue('user_id', $userID, \PDO::PARAM_INT);
        $statement->execute();

        $wishlist = $statement->fetchAll();
        return $wishlist;
        //return  array_unique($wishlist);
    }
    public function deleteWishlist($userID, $productID): void
    {
        $statement = $this->pdo->prepare("DELETE FROM " . static::TABLE . " WHERE product_id=:product_id AND user_id=:user_id");
        $statement->bindValue('product_id', $productID, \PDO::PARAM_INT);
        $statement->bindValue('user_id', $userID, \PDO::PARAM_INT);
        $statement->execute();
    }
}
