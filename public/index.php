<?php
require_once __DIR__ . '/../vendor/autoload.php';

use ProjetoBlog\Infrastructure\Persistence\ConnectionCreator;
use ProjetoBlog\Repository\PostRepository;
use ProjetoBlog\Repository\UserRepository;

$pdo = ConnectionCreator::createconnection();
$postRepository = new PostRepository($pdo);
$userRepository = new UserRepository($pdo);

$routes = require_once __DIR__ . '/../config/routes.php';

session_start();

$pathInfo = $_SERVER['PATH_INFO'] ?? '/';
$httpMethod = $_SERVER['REQUEST_METHOD'];

$httpRoute = "$httpMethod|$pathInfo";

$isLoginRoute = $pathInfo === '/login';
$newUserRoute = $pathInfo === '/novo-usuario';

if (!array_key_exists('logado', $_SESSION) && !$isLoginRoute && !$newUserRoute) {
    $_SESSION['mensagem'] = 'TEM QUE TA LOGADO KRAI';
    header('Location: /login');
    return;
}

if (isset($_SESSION['logado'])) {
    $originalInfo = $_SESSION['logado'];
    unset($_SESSION['logado']);
    session_regenerate_id();
    $_SESSION['logado'] = $originalInfo;
}

if (array_key_exists($httpRoute, $routes)) {
    $controllerClass = $routes[$httpRoute];
    if (stristr($controllerClass, 'login') || stristr($controllerClass, 'User') ) {
        $controller = new $controllerClass($userRepository);
    } else {
        $controller = new $controllerClass($postRepository);
    }
} else {
    //controller de 404
    return http_response_code(404);
}

$controller->processRequest();