<?php
use Cake\Routing\Route\DashedRoute;
use Cake\Routing\RouteBuilder;

return static function (RouteBuilder $routes) {
    $routes->prefix('admin', function (RouteBuilder $routes) {
        $routes->plugin('Cart', function (RouteBuilder $routes) {
            $routes->fallbacks(DashedRoute::class);
        });

        $routes->fallbacks(DashedRoute::class);
    });

    $routes->plugin('Cart', function (RouteBuilder $routes) {
        $routes->fallbacks(DashedRoute::class);
    });
};
