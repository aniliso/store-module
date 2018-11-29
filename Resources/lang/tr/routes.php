<?php

return [
    'index'    => 'katalog',
    'category' => [
        'slug' => 'kategori/{uri}'
    ],
    'product'  => [
        'slug'   => 'urun/{id}/{uri?}',
        'search' => 'urun/ara'
    ],
    'brand'    => [
        'slug' => 'marka/{uri}'
    ]
];