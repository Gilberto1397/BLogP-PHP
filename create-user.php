<?php

$dbPath = __DIR__ . '/baseDados.sqlite';

$pdo = new PDO("sqlite:$dbPath");

$email = $argv[1];
$password = $argv[2];
$hashPassword = password_hash($password, PASSWORD_ARGON2ID);

$sql = 'insert into users (email, password) values (:email, :password);';

$statement = $pdo->prepare($sql);
$statement->bindValue(':email', $email, PDO::PARAM_STR);
$statement->bindValue(':password', $hashPassword, PDO::PARAM_STR);
$statement->execute();
