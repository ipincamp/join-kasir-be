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
            'name' => env('ADMIN_NAME'),
            'username' => env('ADMIN_USERNAME'),
            'password' => Hash::make(env('ADMIN_PASSWORD')),
            'level' => 1,
            'created_at' => now(),
            'created_by' => 0
        ]);
    }
}
