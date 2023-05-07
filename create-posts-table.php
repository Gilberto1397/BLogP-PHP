<?php

$dbPath = __DIR__ . '/baseDados.sqlite';

$pdo = new PDO("sqlite:$dbPath");
$pdo->exec('CREATE TABLE posts (id INTEGER PRIMARY KEY, title TEXT, content TEXT);');