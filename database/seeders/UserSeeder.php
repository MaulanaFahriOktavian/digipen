<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        $users = [
            [
                'name' => 'Administrator Sekolah',
                'email' => 'admin@sch.id',
                'password' => Hash::make('admin123'),
                'role' => 'admin',
                'nis_nip' => 'admin',
            ],
            [
                'name' => 'Petugas Keamanan',
                'email' => 'satpam@sch.id',
                'password' => Hash::make('satpam123'),
                'role' => 'satpam',
                'nis_nip' => 'satpam',
            ],
        ];

        foreach ($users as $user) {
            User::create($user);
        }
    }
}