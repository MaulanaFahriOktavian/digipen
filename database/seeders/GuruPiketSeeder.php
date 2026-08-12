<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Guru;

class GuruPiketSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID guru yang ada di database
        $guruIds = Guru::pluck('id')->toArray();

        // Jika tidak ada guru, hentikan seeder agar tidak error
        if (empty($guruIds)) {
            return;
        }

        $jumlahGuru = count($guruIds);

        // Buat jadwal piket untuk 7 hari ke depan
        for ($i = 0; $i < 7; $i++) {
            $tanggal = now()->addDays($i)->format('Y-m-d');

            // Shift Pagi: Ambil guru berdasarkan urutan bergilir
            $guruPagi = $guruIds[$i % $jumlahGuru];
            
            // Shift Siang: Ambil guru berikutnya
            $guruSiang = $guruIds[($i + 1) % $jumlahGuru];

            // Insert Shift Pagi
            DB::table('guru_piket')->insert([
                'guru_id' => $guruPagi,
                'tanggal' => $tanggal,
                'shift' => 'pagi',
                'created_at' => now(),
                'updated_at' => now(),
            ]);

            // Insert Shift Siang
            DB::table('guru_piket')->insert([
                'guru_id' => $guruSiang,
                'tanggal' => $tanggal,
                'shift' => 'siang',
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}