<?php

namespace App\Model;

<<<<<<< HEAD
=======
use PDO;

>>>>>>> develop
class UserManager extends AbstractManager
{
    public const TABLE = 'WS_user';

    public function addUser(array $user)
    {
<<<<<<< HEAD
        $sql = "INSERT INTO WS_user(user_name, WS_password, email, role, birthday) VALUES (:user_name, :password, :email,'user', :birthday)";
=======
        $sql = "INSERT INTO WS_user(user_name, WS_password, email, role, birthday)
                VALUES (:user_name, :password, :email,
                CASE WHEN :role IS NULL THEN 'user' ELSE :role END, :birthday)";
>>>>>>> develop

        $statement = $this->pdo->prepare($sql);

        $passwordHash = password_hash($user['WS_password'], algo: PASSWORD_DEFAULT);

<<<<<<< HEAD
        $statement->bindParam(':user_name', $user['user_name'], \PDO::PARAM_STR);
        $statement->bindParam(':birthday', $user['birthday'], \PDO::PARAM_STR);
        $statement->bindParam(':email', $user['email'], \PDO::PARAM_STR);
        $statement->bindParam(':password', $passwordHash, \PDO::PARAM_STR);

=======
        $statement->bindParam(':user_name', $user['user_name'], PDO::PARAM_STR);
        $statement->bindParam(':birthday', $user['birthday'], PDO::PARAM_STR);
        $statement->bindParam(':email', $user['email'], PDO::PARAM_STR);
        $statement->bindParam(':password', $passwordHash, PDO::PARAM_STR);
        $statement->bindParam(':role', $user['role'], PDO::PARAM_STR);
>>>>>>> develop
        $statement->execute();
    }

    public function editUser(array $user): bool
    {

        $sql = "UPDATE " . self::TABLE . " SET
                   `user_name` = :user_name,
                   `birthday` = :birthday,
                   `email` = :email,
                   `WS_password` = :WS_password
                   WHERE id =:id";
        $stm = $this->pdo->prepare($sql);

        $passwordHash = password_hash($user['WS_password'], algo: PASSWORD_DEFAULT);

<<<<<<< HEAD
        $stm->bindValue(':user_name', $user['user_name'], \PDO::PARAM_STR);
        $stm->bindValue(':birthday', $user['birthday'], \PDO::PARAM_STR);
        $stm->bindValue(':email', $user['email'], \PDO::PARAM_STR);
        $stm->bindValue(':WS_password', $passwordHash, \PDO::PARAM_STR);
        $stm->bindValue(':id', $user['id'], \PDO::PARAM_INT);
=======
        $stm->bindValue(':user_name', $user['user_name'], PDO::PARAM_STR);
        $stm->bindValue(':birthday', $user['birthday'], PDO::PARAM_STR);
        $stm->bindValue(':email', $user['email'], PDO::PARAM_STR);
        $stm->bindValue(':WS_password', $passwordHash, PDO::PARAM_STR);
        $stm->bindValue(':id', $user['id'], PDO::PARAM_INT);
>>>>>>> develop

        return $stm->execute();
    }

    public function getUserByEmail($email)
    {

        $stm = $this->pdo->prepare("SELECT * FROM WS_user WHERE email = :email");
        $stm->bindValue(':email', $email);
        $stm->execute();

        return $stm->fetch();
    }
}
