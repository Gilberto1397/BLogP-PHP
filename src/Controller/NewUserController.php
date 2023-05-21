<?php

namespace ProjetoBlog\Controller;

use ProjetoBlog\Entity\User;
use ProjetoBlog\Repository\UserRepository;

class NewUserController implements Controller
{
    private UserRepository $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }


    public function processRequest(): void
    {
        $email = filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL);
        if ($email === false) {
            die(123);
            header('Location: /?sucesso=0');
            return;
        }
        $password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
        if ($password === false) {
            die('abc');
            header('Location: /?sucesso=0');
            return;
        }

        $user = new User($email, password_hash($password, PASSWORD_ARGON2ID));

        $success = $this->userRepository->add($user);

        if ($success === false) {
            $_SESSION['mensagem'] = 'Falha ao criar usuário';
            header('Location: /novo-usuario');
        } else {
            $_SESSION['mensagem'] = 'Usuário criado com sucesso';
            header('Location: /login');
            //header('Location: /');
        }
    }
}