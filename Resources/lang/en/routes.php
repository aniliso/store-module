<?php

return [
    'index'    => 'catalog',
    'category' => [
        'slug' => 'category/{uri}'
    ],
    'product'  => [
        'slug'   => 'product/{uri}',
        'search' => 'product/search'
    ],
    'brand'    => [
        'slug' => 'brand/{uri}'
    ]
];