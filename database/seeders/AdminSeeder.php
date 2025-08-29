<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class AdminSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin Sekolah',
            'email' => 'admin@admin.com',
            'password' => Hash::make('password689'), // Ganti dengan password yang aman
            'role' => 'admin',
        ]);
    }
}
