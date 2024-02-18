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
            'name' => env('SU_NAME'),
            'username' => env('SU_USERNAME'),
            'password' => Hash::make(env('SU_PASSWORD')),
            'level' => 1,
            'pin' => 1,
            'created_at' => now(),
            'created_by' => 0
        ]);
    }
}
