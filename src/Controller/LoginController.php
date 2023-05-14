<?php

namespace ProjetoBlog\Controller;

use PDO;

class LoginController implements Controller
{
    public PDO $pdo;
    public function __construct() //TODO FORMA SEM INJEÇÃO DE DEPENDÊNCIA E BOAS PRÁTICAS
    {
        $dbPath = __DIR__ . '/../../baseDados.sqlite';
        $this->pdo = new PDO("sqlite:{$dbPath}");
    }

    public function processRequest(): void
    {
        $email = filter_input(0,'email', 274);
        $password = filter_input(0,'password');

        $sql = 'select * from users where email = :email;';
        $statement = $this->pdo->prepare($sql);
        $statement->bindValue(':email', $email, PDO::PARAM_STR);
        $statement->execute();

        $userData = $statement->fetch(PDO::FETCH_ASSOC);
        $correctPassword = password_verify($password, $userData['password'] ?? ''); //PARA CASO RETORNE FALSE

        if ($correctPassword) {
            if (password_needs_rehash($userData['password'], PASSWORD_ARGON2ID)) {
                $statement = $this->pdo->prepare('UPDATE users SET password = ? WHERE id = ?');
                $statement->bindValue(1, password_hash($password, PASSWORD_ARGON2ID));
                $statement->bindValue(2, $userData['id']);
                $statement->execute();
            }
            $_SESSION['logado'] = true;
            header('Location: /');
        } else {
            $_SESSION['mensagem'] = 'DADOS ERRADOS PORRAAAA!';
            header('Location: /login');
        }

    }
}