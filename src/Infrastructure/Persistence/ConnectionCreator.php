<?php

namespace ProjetoBlog\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    public static function createconnection(): PDO
    {
        $dbPath = __DIR__ . '/../../../baseDados.sqlite';
        return new PDO("sqlite:$dbPath");
    }
}