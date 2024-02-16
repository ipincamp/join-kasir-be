<?php

namespace Database\Seeders;

use App\Models\Toko;
use App\Models\User;
use Illuminate\Database\Seeder;

class TokoSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $adminId = User::where('level', 0)->value('id');

        Toko::create([
            'kode' => 1,
            'name' => 'Toko Admin',
            'created_at' => now(),
            'created_by' => $adminId
        ]);
    }
}
