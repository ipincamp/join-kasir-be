<?php

return [
    'admin' => [
        'name' => env('ADMIN_NAME'),
        'username' => env('ADMIN_USERNAME'),
        'password' => env('ADMIN_PASSWORD'),
    ],
    'roles' => ['admin', 'owner', 'head', 'cashier'],
    'peran' => ['Admin', 'Pemilik', 'Kepala', 'Kasir'],
];
