<?php

Route::resource(
    '/users',
    'UserController',
    [
        'except' => ['edit', 'create']
    ]
);

Route::resource(
    '/cities',
    'CityController',
    [
        'except' => ['edit', 'create']
    ]
);
