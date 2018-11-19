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

Route::resource(
    '/departments',
    'DepartmentController',
    [
        'except' => ['edit', 'create']
    ]
);
