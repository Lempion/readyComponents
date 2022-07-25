<?php

if (!session_id()) @session_start();

require '../vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function (FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\controllers\HomeController', 'index']);

    $r->addRoute('GET', '/post/{id:\d+}', ['App\controllers\HomeController', 'post']);

    $r->addRoute('GET', '/registration', ['App\controllers\HomeController', 'registration']);

    $r->addRoute('POST', '/reg', ['App\controllers\HomeController', 'regForm']);

    $r->addRoute('GET', '/login', ['App\controllers\HomeController', 'login']);

    $r->addRoute('POST', '/log', ['App\controllers\HomeController', 'logForm']);

    $r->addRoute('GET', '/verification', ['App\controllers\HomeController', 'verificationEmail']);

    $r->addRoute('GET', '/admin/roles', ['App\controllers\HomeController', 'roles']);

    $r->addRoute('POST', '/admin/editRole', ['App\controllers\HomeController', 'editRole']);
});

// Fetch method and URI from somewhere
$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

// Strip query string (?foo=bar) and decode URI
if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        echo '404 Not Found';
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        echo '405 Method Not Allowed';
        break;
    case FastRoute\Dispatcher::FOUND:
        $handler = $routeInfo[1];
        $vars = $routeInfo[2];

        $controller = new $handler[0];
        call_user_func([$controller, $handler[1]], $vars);

        break;
}


