<?php

return [
    'index'    => 'catalog',
    'category' => [
        'slug' => 'category/{uri}'
    ],
    'product'  => [
        'slug'   => 'product/{id}/{uri?}',
        'search' => 'product/search'
    ],
    'brand'    => [
        'slug' => 'brand/{uri}'
    ]
];