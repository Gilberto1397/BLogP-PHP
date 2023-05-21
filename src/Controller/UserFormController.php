<?php

namespace ProjetoBlog\Controller;

class UserFormController implements Controller
{
    public function processRequest(): void
    {
        require_once __DIR__ . '/../../views/form-user.php';
    }
}