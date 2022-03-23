<?php

use App\Redirect;
use App\View;
use Twig\Environment;
use Twig\Loader\FilesystemLoader;

require_once 'vendor/autoload.php';

$dispatcher = FastRoute\simpleDispatcher(function(FastRoute\RouteCollector $r) {
    $r->addRoute('GET', '/', ['App\Controllers\PageController', 'showHome']);
    $r->addRoute('GET', '/services', ['App\Controllers\PageController', 'showServices']);
    $r->addRoute('GET', '/about', ['App\Controllers\PageController', 'showAbout']);
    $r->addRoute('GET', '/contact', ['App\Controllers\PageController', 'showContact']);
    $r->addRoute('GET', '/more', ['App\Controllers\PageController', 'showLearnMore']);
    $r->addRoute('GET', '/faq', ['App\Controllers\PageController', 'showFaq']);
    $r->addRoute('GET', '/signup', ['App\Controllers\SignupController', 'signup']);
    $r->addRoute('POST', '/signup', ['App\Controllers\SignupController', 'storeUser']);
    $r->addRoute('GET', '/success/{userId:\d+}/{name}', ['App\Controllers\PageController', 'showSuccess']);

});

$httpMethod = $_SERVER['REQUEST_METHOD'];
$uri = $_SERVER['REQUEST_URI'];

if (false !== $pos = strpos($uri, '?')) {
    $uri = substr($uri, 0, $pos);
}
$uri = rawurldecode($uri);

$routeInfo = $dispatcher->dispatch($httpMethod, $uri);
switch ($routeInfo[0]) {
    case FastRoute\Dispatcher::NOT_FOUND:
        break;
    case FastRoute\Dispatcher::METHOD_NOT_ALLOWED:
        $allowedMethods = $routeInfo[1];
        break;
    case FastRoute\Dispatcher::FOUND:

        $controller = $routeInfo[1][0];
        $method = $routeInfo[1][1];
        $vars = $routeInfo[2];

        $response = (new $controller)->$method($vars);

        $loader = new FilesystemLoader('app/Views');
        $twig = new Environment($loader);

        if ($response instanceof View) {
            echo $twig->render($response->getPath(), $response->getVariables());
        }

        if ($response instanceof Redirect) {
            header('Location: ' . $response->getLocation());
            exit;
        }

        break;
}