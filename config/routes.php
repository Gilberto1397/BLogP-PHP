<?php

use ProjetoBlog\Controller\DeletePostController;
use ProjetoBlog\Controller\EditPostController;
use ProjetoBlog\Controller\NewPostController;
use ProjetoBlog\Controller\PostFormController;
use ProjetoBlog\Controller\PostListController;

return [
    'GET|/' => PostListController::class,
    'GET|/novo-post' => PostFormController::class,
    'POST|/novo-post' => NewPostController::class,
    'GET|/editar-post' => PostFormController::class,
    'POST|/editar-post' => EditPostController::class,
    'GET|/deletar-post' => DeletePostController::class,
];
