<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class SiswaSeeder extends Seeder
{
    public function run(): void
    {
        $siswaData = [
            [
                'nis' => '12345',
                'nama_lengkap' => 'Ahmad Fauzi',
                'email' => 'ahmad@sch.id',
                'tanggal_lahir' => '2000-01-01',
                'alamat' => 'Jl. Merdeka No. 10, Jakarta',
                'no_telepon' => '081234567890',
                'kelas_id' => 1,
                'jurusan_id' => 1,
            ],
        ];

        foreach ($siswaData as $data) {
            // 1. Buat Akun User Siswa
            $user = User::create([
                'name' => $data['nama_lengkap'],
                'email' => $data['email'],
                'password' => Hash::make('password'), // Password default (Siswa login pakai Tgl Lahir, tapi DB butuh password)
                'role' => 'siswa',
                'nis_nip' => $data['nis'],
            ]);

            // 2. Buat Profil Siswa dengan user_id yang baru saja dibuat
            DB::table('siswa')->insert([
                'user_id' => $user->id,
                'nama_lengkap' => $data['nama_lengkap'],
                'tanggal_lahir' => $data['tanggal_lahir'],
                'alamat' => $data['alamat'],
                'no_telepon' => $data['no_telepon'],
                'kelas_id' => $data['kelas_id'],
                'jurusan_id' => $data['jurusan_id'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}