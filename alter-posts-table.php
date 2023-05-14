<?php

$dbPath = __DIR__ . '/baseDados.sqlite';

$pdo = new PDO("sqlite:$dbPath");
$pdo->exec('alter TABLE posts add column image_path TEXT;');