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

    /**
     * @param  User  $user
     * @return void
     * @throws \PDOException
     */
    public function add(User $user): void
    {
        try {
            $sql = 'insert into users (email, password) values (:email, :password)';
            $statement = $this->connection->prepare($sql);
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':password', $user->getPassword());

            $result = $statement->execute();
            $id = $this->connection->lastInsertId();

            $user->setId((int)$id);
            return;
        } catch (\PDOException $exception) {
            $_SESSION['mensagem'] = 'Falha ao salvar novo usuário no banco de dados.';
            header('Location: /novo-usuario');
            die();
        }
    }

    /**
     * @param  string  $email
     * @return User
     * @throws \PDOException | \DomainException
     */
    public function find(string $email)
    {
        try {
            $statement = $this->connection->prepare('select * from users where email = :email');
            $statement->bindValue(':email', $email, PDO::PARAM_STR);
            $statement->execute();
            $userData = $statement->fetch(PDO::FETCH_ASSOC);

            if ($userData === false) {
                throw new \DomainException('Dados de login inválidos');
            }
            return $this->hydrateUser($userData);
        } catch (\PDOException|\DomainException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();

            if (is_a($exception, \PDOException::class)) {
                $_SESSION['mensagem'] = 'Houve um problema ao tentar logar-se, contate o suporte';
            }
            header('Location: /login');
            die();
        }
    }

    private function hydrateUser(array $userData): User
    {
        $user = new User($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}