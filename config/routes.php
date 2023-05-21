<?php

use ProjetoBlog\Controller\DeletePostController;
use ProjetoBlog\Controller\EditPostController;
use ProjetoBlog\Controller\JsonPostListController;
use ProjetoBlog\Controller\LoginController;
use ProjetoBlog\Controller\LoginFormController;
use ProjetoBlog\Controller\LogoutController;
use ProjetoBlog\Controller\NewJsonPostController;
use ProjetoBlog\Controller\NewPostController;
use ProjetoBlog\Controller\NewUserController;
use ProjetoBlog\Controller\PostFormController;
use ProjetoBlog\Controller\PostListController;
use ProjetoBlog\Controller\UserFormController;

return [
    'GET|/' => PostListController::class,
    'GET|/novo-post' => PostFormController::class,
    'POST|/novo-post' => NewPostController::class,
    'GET|/editar-post' => PostFormController::class,
    'POST|/editar-post' => EditPostController::class,
    'GET|/deletar-post' => DeletePostController::class,
    'GET|/login' => LoginFormController::class,
    'POST|/login' => LoginController::class,
    'GET|/logout' => LogoutController::class,
    'GET|/posts-json' => JsonPostListController::class,
    'POST|/posts' => NewJsonPostController::class,
    'GET|/novo-usuario' => UserFormController::class,
    'POST|/novo-usuario' => NewUserController::class
];
