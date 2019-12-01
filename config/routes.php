<?php
use Cake\Routing\RouteBuilder;
use Cake\Routing\Router;
use Cake\Routing\Route\DashedRoute;

Router::prefix('admin', function (RouteBuilder $routes) {
    $routes->plugin('Cart', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });

        $routes->fallbacks(DashedRoute::class);
});

Router::plugin('Cart', function (RouteBuilder $routes) {
    $routes->fallbacks(DashedRoute::class);
});
