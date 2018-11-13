<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group([], function (Router $router) {
    $router->pattern('sku', '[a-z0-9-]+');
    $router->get(LaravelLocalization::transRoute('store::routes.index'), [
        'uses' => 'PublicController@index',
        'as'   => 'store.index'
    ]);
    $router->any(LaravelLocalization::transRoute('store::routes.category.slug'), [
        'uses' => 'PublicController@category',
        'as'   => 'store.category.slug'
    ]);
    $router->any(LaravelLocalization::transRoute('store::routes.product.slug'), [
        'uses' => 'PublicController@product',
        'as'   => 'store.product.slug'
    ]);
});





