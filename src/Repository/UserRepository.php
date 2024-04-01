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
     * @param  User $user
     * @return bool
     * @throws \PDOException
     */
    public function add(User $user): bool
    {
        try {
            $sql = 'insert into users (email, password) values (:email, :password)';
            $statement = $this->connection->prepare($sql);
            $statement->bindValue(':email', $user->getEmail());
            $statement->bindValue(':password', $user->getPassword());

            $result = $statement->execute();
            $id = $this->connection->lastInsertId();

            $user->setId((int)$id);
        } catch (\PDOException $exception) {
            $_SESSION['mensagem'] = 'Falha ao salvar novo usuário no banco de dados.';
            header('Location: /novo-usuario');
        }
        return $result;
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

            if ($userData === false) { // FAZER TESTE COM EMAIL INEXISTENTE
                throw new \DomainException('Usuário inválido!');
            }
            return $this->hydrateUser($userData);
        } catch (\PDOException | \DomainException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();

            if (is_a($exception, \PDOException::class)) {
                $_SESSION['mensagem'] = 'Houve um problema ao tentar logar-se, contate o suporte';
                header('Location: /login');
                return;
            }
            header('Location: /login');
        }
    }

    private function hydrateUser(array $userData): User
    {
        $user = new User($userData['email'], $userData['password']);
        $user->setId($userData['id']);

        return $user;
    }
}