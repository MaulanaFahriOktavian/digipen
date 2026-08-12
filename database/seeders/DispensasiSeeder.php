<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use App\Models\Siswa;
use App\Models\GuruPiket;

class DispensasiSeeder extends Seeder
{
    public function run(): void
    {
        // Ambil semua ID siswa dan guru piket yang ada di database
        $siswaIds = Siswa::pluck('id')->toArray();
        $guruPiketIds = GuruPiket::pluck('id')->toArray();

        // Jika tidak ada siswa atau guru piket, hentikan seeder agar tidak error
        if (empty($siswaIds) || empty($guruPiketIds)) {
            return;
        }

        $dispensasiData = [
            [
                'nomor_surat' => 'DISP-2026-0001',
                'siswa_id' => $siswaIds[0], // Ambil siswa pertama
                'guru_piket_id' => $guruPiketIds[0], // Ambil guru piket pertama
                'kategori' => 'lainnya', // ✅ Menggunakan nilai enum yang valid
                'alasan' => 'Sakit gigi, perlu periksa ke dokter',
                'tujuan' => 'Klinik Kesehatan',
                'lokasi' => 'Jl. Sehat No. 1',
                'jam_keluar' => now()->subHour(),
                'jam_kembali' => now()->addHour(),
                'status' => 'menunggu',
                'print_count' => 0,
                'max_print_limit' => 3,
            ],
            [
                'nomor_surat' => 'DISP-2026-0002',
                'siswa_id' => $siswaIds[1] ?? $siswaIds[0], // Ambil siswa kedua atau pertama jika tidak ada
                'guru_piket_id' => $guruPiketIds[0],
                'kategori' => 'lainnya', // ✅ Menggunakan nilai enum yang valid
                'alasan' => 'Ada urusan keluarga mendadak',
                'tujuan' => 'Rumah orang tua',
                'lokasi' => 'Jl. Keluarga No. 8',
                'jam_keluar' => now()->subHours(2),
                'jam_kembali' => now()->addHours(2),
                'status' => 'disetujui',
                'catatan_admin' => 'Dipersilakan',
                'print_count' => 0,
                'max_print_limit' => 3,
            ],
            [
                'nomor_surat' => 'DISP-2026-0003',
                'siswa_id' => $siswaIds[2] ?? $siswaIds[0], // Ambil siswa ketiga atau pertama jika tidak ada
                'guru_piket_id' => $guruPiketIds[0],
                'kategori' => 'lainnya', // ✅ Menggunakan nilai enum yang valid
                'alasan' => 'Mengikuti lomba tingkat provinsi',
                'tujuan' => 'Gedung Olahraga',
                'lokasi' => 'Jl. Merdeka No. 10',
                'jam_keluar' => now()->subHours(3),
                'jam_kembali' => now()->addHours(3),
                'status' => 'menunggu',
                'print_count' => 0,
                'max_print_limit' => 3,
            ],
        ];

        foreach ($dispensasiData as $data) {
            DB::table('dispensasi')->insert(array_merge($data, [
                'created_at' => now(),
                'updated_at' => now(),
            ]));
        }
    }
}