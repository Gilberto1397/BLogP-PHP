<?php

namespace ProjetoBlog\Controller;

class LogoutController implements Controller
{
    public function processRequest(): void
    {
        unset($_SESSION['logado']);
        header('Location: /login');
    }
}