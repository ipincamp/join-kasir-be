<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // admin
        User::create([
            'name' => config('api.admin.name'),
            'username' => config('api.admin.username'),
            'password' => Hash::make(config('api.admin.password')),
            'level' => 1,
            'created_by' => 0,
        ]);
    }
}
