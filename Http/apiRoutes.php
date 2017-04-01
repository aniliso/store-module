<?php

use Illuminate\Routing\Router;

/** @var Router $router */
$router->group(['prefix' => 'v1/store/product', 'middleware' => 'api.token'], function (Router $router) {
    $router->get('related', [
        'as'         => 'api.store.product.related',
        'uses'       => 'V1\ProductController@related',
        'middleware' => 'token-can:api.store.product.related',
    ]);
    $router->post('update', [
        'as'         => 'api.store.product.update',
        'uses'       => 'V1\ProductController@update',
        'middleware' => 'token-can:api.store.product.update',
    ]);
});

$router->group(['prefix' => 'v1/store/category', 'middleware' => 'api.token'], function (Router $router) {
    $router->get('lists', [
        'as'         => 'api.store.category.lists',
        'uses'       => 'V1\CategoryController@lists',
        'middleware' => 'token-can:api.store.category.lists',
    ]);
    $router->post('update', [
        'as'         => 'api.store.category.update',
        'uses'       => 'V1\CategoryController@update',
        'middleware' => 'token-can:api.store.category.update',
    ]);
});
