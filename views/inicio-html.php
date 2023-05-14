<?php

$message = null;

if (!empty($_SESSION['mensagem'])) {
    $message = $_SESSION['mensagem'];
    unset($_SESSION['mensagem']);
}

?><!DOCTYPE html>
<html lang="pt-br">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="/css/reset.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/css/bootstrap.min.css">
    <title>ProjetoBLOG</title>
    <link rel="shortcut icon" href="./img/favicon.ico" type="image/x-icon">
</head>

<body>

<nav class="navbar navbar-expand-lg bg-primary">
    <div class="container-fluid">
        <div class="collapse navbar-collapse justify-content-center" id="navbarNavAltMarkup">
            <div class="navbar-nav">
                <a class="nav-link text-light" href="/">Home</a>
                <a class="nav-link text-light" href="/novo-post">Novo Post</a>
                <a class="nav-link text-light" href="/login">Entrar</a>
                <a class="nav-link text-light" href="/logout">Sair</a>
            </div>
        </div>
    </div>
</nav>

<div class="message">
    <h3><?= $message ?? '' ?></h3>
</div>