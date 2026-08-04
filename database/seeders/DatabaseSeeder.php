<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        User::firstOrCreate(
            ['username' => env('PJPK_ADMIN_USERNAME', 'superadmin')],
            [
                'name' => env('PJPK_ADMIN_NAME', 'Super Administrator'),
                'email' => env('PJPK_ADMIN_EMAIL', 'admin@pjpkmura.go.id'),
                'password' => env('PJPK_ADMIN_PASSWORD', 'Admin@12345'),
                'role' => 'superadmin',
                'instansi' => 'Pemerintah Kabupaten Murung Raya',
                'is_active' => true,
            ],
        );
    }
}
