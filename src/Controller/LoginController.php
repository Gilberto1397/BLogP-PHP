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

    public function processRequest(): void
    {
        $email = filter_input(0,'email', 274);
        $password = filter_input(0,'password');
        $lembrar = isset($_POST['lembrar']);

        $userData = $this->repository->find($email);
        $correctPassword = password_verify($password, $userData instanceof User ? $userData->getPassword() : ''); //PARA CASO RETORNE FALSE

        if ($correctPassword) { //TODO criar camada para essa parte
            if (password_needs_rehash($userData->getPassword(), PASSWORD_ARGON2ID)) {
                $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
                $statement->bindValue(2, $userData['id']);
                $statement->execute();
            }
            $_SESSION['logado'] = true;

            if ($lembrar) {
                $_SESSION['usuario'] = $email;
            } else {
                unset($_SESSION['usuario']);
            }
            header('Location: /');
        } else {
            $_SESSION['mensagem'] = 'DADOS ERRADOS PORRAAAA!';
            header('Location: /login');
        }

    }
}