<?php

$dbPath = __DIR__ . '/baseDados.sqlite';

$pdo = new PDO("sqlite:$dbPath");
$pdo->exec('CREATE TABLE users (id INTEGER PRIMARY KEY, email TEXT, password TEXT);');