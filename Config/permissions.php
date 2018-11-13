<?php

return [
    'store.categories'   => [
        'index'   => 'store::categories.list resource',
        'create'  => 'store::categories.create resource',
        'edit'    => 'store::categories.edit resource',
        'destroy' => 'store::categories.destroy resource',
    ],
    'store.products'     => [
        'index'     => 'store::products.list resource',
        'create'    => 'store::products.create resource',
        'edit'      => 'store::products.edit resource',
        'destroy'   => 'store::products.destroy resource',
        'duplicate' => 'store::products.duplicate resource',
    ],
    'store.brands'       => [
        'index'   => 'store::brands.list resource',
        'create'  => 'store::brands.create resource',
        'edit'    => 'store::brands.edit resource',
        'destroy' => 'store::brands.destroy resource',
    ],
    'api.store.product'  => [
        'related' => 'store::products.related resource',
        'update'  => 'store::products.edit resource'
    ],
    'api.store.category' => [
        'lists'  => 'store::categories.list resource',
        'update' => 'store::categories.edit resource'
    ]
];
