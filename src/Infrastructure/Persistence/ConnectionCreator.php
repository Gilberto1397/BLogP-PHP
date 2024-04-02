<?php

namespace ProjetoBlog\Infrastructure\Persistence;

use PDO;

class ConnectionCreator
{
    const options = [
        PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
    ];
    public static function createconnection(): PDO
    {
        $dbPath = __DIR__ . '/../../../baseDados.sqlite';
        return new PDO("sqlite:$dbPath", null, null, self::options);
    }
}