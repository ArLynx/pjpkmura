<?php

namespace Database\Seeders;

use App\Models\Instansi;
use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    public function run(): void
    {
        $instansi = Instansi::firstOrCreate(
            ['nama' => env('PJPK_ADMIN_INSTANSI', 'Pemerintah Kabupaten Murung Raya')],
        );

        $admins = [
            [
                'username' => env('PJPK_ADMIN_USERNAME', 'superadmin'),
                'name' => env('PJPK_ADMIN_NAME', 'Super Administrator'),
                'email' => env('PJPK_ADMIN_EMAIL', 'admin@pjpkmura.go.id'),
                'password' => env('PJPK_ADMIN_PASSWORD', 'Admin@12345'),
            ],
            [
                'username' => env('PJPK_ADMIN2_USERNAME', 'superadmin2'),
                'name' => env('PJPK_ADMIN2_NAME', 'Super Administrator 2'),
                'email' => env('PJPK_ADMIN2_EMAIL', 'admin2@pjpkmura.go.id'),
                'password' => env('PJPK_ADMIN2_PASSWORD', 'Admin@12345'),
            ],
        ];

        foreach ($admins as $admin) {
            User::firstOrCreate(
                ['username' => $admin['username']],
                [
                    'name' => $admin['name'],
                    'email' => $admin['email'],
                    'password' => $admin['password'],
                    'role' => 'superadmin',
                    'instansi_id' => $instansi->id,
                    'is_active' => true,
                ],
            );
        }
    }
}
