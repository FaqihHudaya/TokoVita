<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        User::create([
    'nama' => 'Admin',
    'email' => 'admin@gmail.com',
    'no_telfon' => '08123456789',
    'password' => Hash::make('admin123'),
    'role' => 'admin'
]);
    }
}
