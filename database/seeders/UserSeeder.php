<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // superuser
        User::create([
            'name' => env('SUPERUSER_NAME'),
            'username' => env('SUPERUSER_USERNAME'),
            'password' => Hash::make(env('SUPERUSER_PASSWORD')),
            'level' => 0,
            'pin' => 1,
            'created_at' => now(),
            'created_by' => 0
        ]);

        // owner
        User::create([
            'name' => 'Owner User',
            'username' => 'owner',
            'password' => Hash::make(123456),
            'level' => 1,
            'pin' => 1,
            'created_at' => now(),
            'created_by' => 1
        ]);

        // leader
        User::create([
            'name' => 'Leader User',
            'username' => 'leader',
            'password' => Hash::make(123456),
            'level' => 2,
            'pin' => 0,
            'created_at' => now(),
            'created_by' => 1
        ]);

        // cashier
        User::create([
            'name' => 'Cashier User',
            'username' => 'cashier',
            'password' => Hash::make(123456),
            'level' => 3,
            'pin' => 0,
            'created_at' => now(),
            'created_by' => 1
        ]);
    }
}
