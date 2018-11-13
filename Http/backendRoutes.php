<?php

use Illuminate\Routing\Router;
/** @var Router $router */

$router->group(['prefix' =>'/store'], function (Router $router) {
    $router->bind('storeCategory', function ($id) {
        return app('Modules\Store\Repositories\CategoryRepository')->find($id);
    });
    $router->get('categories', [
        'as' => 'admin.store.category.index',
        'uses' => 'CategoryController@index',
        'middleware' => 'can:store.categories.index'
    ]);
    $router->get('categories/create', [
        'as' => 'admin.store.category.create',
        'uses' => 'CategoryController@create',
        'middleware' => 'can:store.categories.create'
    ]);
    $router->post('categories', [
        'as' => 'admin.store.category.store',
        'uses' => 'CategoryController@store',
        'middleware' => 'can:store.categories.create'
    ]);
    $router->get('categories/{storeCategory}/edit', [
        'as' => 'admin.store.category.edit',
        'uses' => 'CategoryController@edit',
        'middleware' => 'can:store.categories.edit'
    ]);
    $router->put('categories/{storeCategory}', [
        'as' => 'admin.store.category.update',
        'uses' => 'CategoryController@update',
        'middleware' => 'can:store.categories.edit'
    ]);
    $router->delete('categories/{storeCategory}', [
        'as' => 'admin.store.category.destroy',
        'uses' => 'CategoryController@destroy',
        'middleware' => 'can:store.categories.destroy'
    ]);
    $router->bind('product', function ($id) {
        return app('Modules\Store\Repositories\ProductRepository')->find($id);
    });
    $router->get('products', [
        'as' => 'admin.store.product.index',
        'uses' => 'ProductController@index',
        'middleware' => 'can:store.products.index'
    ]);
    $router->get('products/create', [
        'as' => 'admin.store.product.create',
        'uses' => 'ProductController@create',
        'middleware' => 'can:store.products.create'
    ]);
    $router->post('products', [
        'as' => 'admin.store.product.store',
        'uses' => 'ProductController@store',
        'middleware' => 'can:store.products.create'
    ]);
    $router->get('products/{product}/edit', [
        'as' => 'admin.store.product.edit',
        'uses' => 'ProductController@edit',
        'middleware' => 'can:store.products.edit'
    ]);
    $router->put('products/{product}', [
        'as' => 'admin.store.product.update',
        'uses' => 'ProductController@update',
        'middleware' => 'can:store.products.edit'
    ]);
    $router->get('product/{product}/duplicate', [
        'as' => 'admin.store.product.duplicate',
        'uses' => 'ProductController@duplicate',
        'middleware' => 'can:store.products.duplicate'
    ]);
    $router->delete('products/{product}', [
        'as' => 'admin.store.product.destroy',
        'uses' => 'ProductController@destroy',
        'middleware' => 'can:store.products.destroy'
    ]);
    $router->bind('brand', function ($id) {
        return app('Modules\Store\Repositories\BrandRepository')->find($id);
    });
    $router->get('brands', [
        'as' => 'admin.store.brand.index',
        'uses' => 'BrandController@index',
        'middleware' => 'can:store.brands.index'
    ]);
    $router->get('brands/create', [
        'as' => 'admin.store.brand.create',
        'uses' => 'BrandController@create',
        'middleware' => 'can:store.brands.create'
    ]);
    $router->post('brands', [
        'as' => 'admin.store.brand.store',
        'uses' => 'BrandController@store',
        'middleware' => 'can:store.brands.create'
    ]);
    $router->get('brands/{brand}/edit', [
        'as' => 'admin.store.brand.edit',
        'uses' => 'BrandController@edit',
        'middleware' => 'can:store.brands.edit'
    ]);
    $router->put('brands/{brand}', [
        'as' => 'admin.store.brand.update',
        'uses' => 'BrandController@update',
        'middleware' => 'can:store.brands.edit'
    ]);
    $router->delete('brands/{brand}', [
        'as' => 'admin.store.brand.destroy',
        'uses' => 'BrandController@destroy',
        'middleware' => 'can:store.brands.destroy'
    ]);
// append



});
