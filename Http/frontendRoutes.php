<?php

use Illuminate\Routing\Router;

/** @var Router $router */

$router->group([], function (Router $router) {
    $router->pattern('sku', '[a-z0-9-]+');
    $router->get(LaravelLocalization::transRoute('store::routes.index'), [
        'uses' => 'PublicController@index',
        'as'   => 'store.index'
    ]);
    $router->get(LaravelLocalization::transRoute('store::routes.category.slug'), [
        'uses' => 'PublicController@category',
        'as'   => 'store.category.slug'
    ]);
    $router->get(LaravelLocalization::transRoute('store::routes.brand.slug'), [
        'uses' => 'PublicController@brand',
        'as'   => 'store.brand.slug'
    ]);
    $router->any(LaravelLocalization::transRoute('store::routes.product.search'), [
        'uses' => 'PublicController@search',
        'as'   => 'store.product.search'
    ]);
    $router->get(LaravelLocalization::transRoute('store::routes.product.slug'), [
        'uses' => 'PublicController@product',
        'as'   => 'store.product.slug'
    ]);
});





