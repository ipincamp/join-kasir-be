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
        // admin
        $admin = User::create([
            'name' => config('api.admin.name'),
            'username' => config('api.admin.username'),
            'password' => Hash::make(config('api.admin.password')),
            'created_by' => 0,
        ]);

        $admin->assignRole('admin');
    }
}
