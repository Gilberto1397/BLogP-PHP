<?php

namespace ProjetoBlog\Repository;

use PDO;
use ProjetoBlog\Entity\User;

class UserRepository
{
    private PDO $connection;

    public function __construct(PDO $connection)
    {
        $this->connection = $connection;
    }

    public function add(User $user): bool
    {
        $sql = 'insert into users (email, password) values (:email, :password)';
        $statement = $this->connection->prepare($sql);
        $statement->bindValue(':email', $user->getEmail(), PDO::PARAM_STR);
        $statement->bindValue(':password', $user->getPassword(), PDO::PARAM_STR);

        $result = $statement->execute();
        $id = $this->connection->lastInsertId();

        $user->setId((int)$id);
        return $result;
    }

    /**
     * @param string $email
     * @return false|User
     */
    public function find(string $email)
    {
        $statement = $this->connection->prepare('select * from users where email = :email');
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();
        $userData = $statement->fetch(PDO::FETCH_ASSOC);

        if ($userData === false) {
            return false;
        }
        return $this->hydrateUser($userData);
    }

    private function hydrateUser(array $userData): User
    {
        $user = new User($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}