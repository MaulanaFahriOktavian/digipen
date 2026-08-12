<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class GuruSeeder extends Seeder
{
    public function run(): void
    {
        $guruData = [
            [
                'nip' => '198501012010011001',
                'nama_lengkap' => 'Budi Santoso, S.Pd',
                'email' => 'budi@sch.id',
                'username' => 'budi',
                'mata_pelajaran' => 'Pemrograman Web',
            ],
            [
                'nip' => '199005122012012002',
                'nama_lengkap' => 'Siti Aminah, M.Pd',
                'email' => 'siti@sch.id',
                'username' => 'siti',
                'mata_pelajaran' => 'Basis Data',
            ],
        ];

        foreach ($guruData as $data) {
            // 1. Cari atau Buat Akun User Guru
            $user = User::firstOrCreate(
                ['email' => $data['email']],
                [
                    'name' => $data['nama_lengkap'],
                    'password' => Hash::make('password'),
                    'role' => 'guru',
                    'nis_nip' => $data['username'],
                ]
            );

            // 2. Buat Profil Guru
            DB::table('guru')->insert([
                'user_id' => $user->id,
                'nip' => $data['nip'],
                'nama_lengkap' => $data['nama_lengkap'],
                'mata_pelajaran' => $data['mata_pelajaran'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}