<?php

use Cake\Http\Middleware\CsrfProtectionMiddleware;
use Cake\Core\Plugin;
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;


Router::defaultRouteClass(DashedRoute::class);

Router::scope(
    '/articles',
    ['controller' => 'Articles'],
    function ($routes) {
        $routes->connect('/tagged/*', ['action' => 'tags']);
    }
);

Router::scope('/', function (RouteBuilder $routes) {
    // Register scoped middleware for in scopes.
    $routes->registerMiddleware('csrf', new CsrfProtectionMiddleware([
        'httpOnly' => true
    ]));


    $routes->applyMiddleware('csrf');


    $routes->connect('/', ['controller' => 'Pages',
     'action' => 'display', 'home']);


    $routes->connect('/pages/*', ['controller' => 'Pages',
     'action' => 'display']);


    $routes->fallbacks(DashedRoute::class);
});

Plugin::routes();
