<?php

return [
    'admin' => [
        'name' => env('ADMIN_NAME', 'Super Admin'),
        'username' => env('ADMIN_USERNAME', 'admin'),
        'password' => env('ADMIN_PASSWORD', 'admin123'),
    ],
    'roles' => ['admin', 'owner', 'head', 'cashier'],
    'peran' => ['Admin', 'Pemilik', 'Kepala', 'Kasir'],
];
