<?php

namespace ProjetoBlog\Controller;

use PDO;
use ProjetoBlog\Entity\User;
use ProjetoBlog\Repository\UserRepository;

class LoginController implements Controller
{
    private UserRepository $repository;

    public function __construct(UserRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @return void
     * @throws \DomainException | \InvalidArgumentException
     */
    public function processRequest(): void
    {
        try {
            $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
            if ($email === false) {
                throw new \InvalidArgumentException('Dados de login inválidos.');
            }

            $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $lembrar = isset($_POST['lembrar']);

            $userData = $this->repository->find($email);
            $correctPassword = password_verify($password, $userData instanceof User ? $userData->getPassword() : '');

            if (!$correctPassword) {
               throw new \DomainException('Dados de login inválidos.');
            }

//            if (password_needs_rehash($userData->getPassword(), PASSWORD_ARGON2ID)) {
//                $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?'); //????? - rever annotation de exceção ao arrumar isso
//                $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
//                $statement->bindValue(2, $userData['id']);
//                $statement->execute();
//            }
            $_SESSION['logado'] = true;

            if ($lembrar) {
                $_SESSION['usuario'] = $email;
            } else {
                unset($_SESSION['usuario']);
            }

            header('Location: /');

        } catch (\DomainException | \InvalidArgumentException $exception) {
            $_SESSION['mensagem'] = $exception->getMessage();
            header('Location: /login');
        }
    }
}


