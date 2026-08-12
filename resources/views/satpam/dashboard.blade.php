@extends('satpam.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Satpam')

@section('content')

{{-- ============ HERO ============ --}}
<div class="relative overflow-hidden rounded-2xl mb-4">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-600 to-sky-500"></div>
    <div class="absolute -top-16 -right-16 w-56 h-56 bg-white/10 rounded-full"></div>
    <div class="absolute -bottom-20 left-20 w-60 h-60 bg-white/10 rounded-full"></div>

    <div class="relative z-10 p-4 sm:p-6 flex items-center justify-between gap-3">
        <div class="min-w-0">
            <p class="text-blue-100 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest">
                {{ now()->format('d M Y') }} • Pos Gerbang
            </p>
            <h2 class="text-lg sm:text-2xl font-black text-white tracking-tight mt-0.5 truncate">
                Halo, {{ auth()->user()->name }} 👋
            </h2>
            <p class="text-blue-100 text-[11px] mt-1 hidden sm:block">Pantau keluar-masuk siswa dispensasi hari ini.</p>
        </div>
        <a href="{{ route('satpam.scan') }}" class="hidden sm:inline-flex items-center px-5 py-3 rounded-xl bg-white text-blue-700 text-sm font-bold shadow-xl hover:-translate-y-0.5 transition-all flex-shrink-0">
            <i class="fas fa-qrcode mr-2"></i> Scan QR
        </a>
    </div>
</div>

{{-- ============ STATISTIK (2 kolom di HP, 4 kolom di desktop) ============ --}}
<div class="grid grid-cols-2 gap-2 sm:gap-4 mb-4 md:grid-cols-4">
    @php
        $cards = [
            ['Menunggu Keluar', $stats['menunggu_keluar'] ?? 0, 'fa-door-open',         'bg-amber-100 text-amber-600',       'border-amber-400',    'Dispensasi disetujui'],
            ['Sedang Keluar',   $stats['total_keluar'] ?? 0,    'fa-person-walking',    'bg-sky-100 text-sky-600',           'border-sky-400',      'Di luar sekolah'],
            ['Sudah Kembali',   $stats['selesai'] ?? 0,         'fa-check-circle',      'bg-emerald-100 text-emerald-600',   'border-emerald-400',  'Hari ini'],
            ['Total Hari Ini',  $stats['hari_ini'] ?? 0,        'fa-file-lines',        'bg-blue-100 text-blue-600',         'border-blue-400',     'Semua dispensasi'],
        ];
    @endphp
    @foreach($cards as [$label, $value, $icon, $color, $border, $sub])
        <div class="bg-white rounded-xl border border-gray-100 border-l-4 {{ $border }} shadow-sm p-3 sm:p-5">
            <div class="flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="text-gray-500 text-[11px] sm:text-xs font-semibold truncate">{{ $label }}</p>
                    <h3 class="text-xl sm:text-3xl font-black text-gray-800 mt-0.5">{{ $value }}</h3>
                    <p class="text-[10px] text-gray-400 mt-0.5 hidden sm:block">{{ $sub }}</p>
                </div>
                <div class="p-2 sm:p-3 rounded-lg sm:rounded-xl {{ $color }} flex-shrink-0">
                    <i class="fas {{ $icon }} text-sm sm:text-lg"></i>
                </div>
            </div>
        </div>
    @endforeach
</div>

{{-- ============ MENUNGGU KONFIRMASI KELUAR ============ --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-4">
    <div class="px-4 py-3 sm:p-5 border-b border-gray-100 bg-amber-50/60 flex items-center justify-between gap-2">
        <div>
            <h3 class="text-sm font-bold text-amber-800">
                <i class="fas fa-clock mr-1.5"></i>Menunggu Konfirmasi Keluar
            </h3>
            <p class="text-[11px] text-amber-600 mt-0.5">Disetujui, belum keluar gerbang.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full bg-amber-500 text-white text-[10px] font-bold flex-shrink-0">
            {{ $menungguKeluar->count() }}
        </span>
    </div>

    {{-- MOBILE: Kartu --}}
    <div class="md:hidden divide-y divide-gray-100">
        @forelse($menungguKeluar as $s)
            <div class="p-4">
                <div class="flex justify-between items-start gap-2 mb-1">
                    <p class="font-mono font-bold text-gray-800 text-xs">{{ $s->nomor_surat }}</p>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-emerald-100 text-emerald-700 border border-emerald-200">Disetujui</span>
                </div>
                <p class="font-bold text-gray-900 text-sm truncate">{{ $s->siswa->nama_lengkap }}</p>
                <p class="text-[11px] text-gray-500 truncate">{{ $s->siswa->kelas->nama_kelas }} • {{ $s->siswa->kelas->jurusan->nama_jurusan }}</p>
                <div class="flex items-center gap-2 mt-2 text-[11px]">
                    <span class="inline-flex items-center px-2 py-1 rounded-lg bg-blue-50 text-blue-700 font-semibold">
                        <i class="far fa-clock mr-1"></i>{{ $s->jam_keluar }}
                    </span>
                    <span class="text-gray-400">→</span>
                    <span class="inline-flex items-center px-2 py-1 rounded-lg bg-amber-50 text-amber-700 font-semibold">
                        {{ $s->jam_kembali }}
                    </span>
                </div>
                <form method="POST" action="{{ route('satpam.konfirmasi.keluar', $s) }}" class="mt-3">
                    @csrf
                    <button type="submit"
                            data-confirm="Konfirmasi {{ $s->siswa->nama_lengkap }} KELUAR dari sekolah?"
                            class="w-full inline-flex justify-center items-center px-4 py-3 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-md shadow-blue-500/20 active:scale-[0.98] transition-all">
                        <i class="fas fa-door-open mr-1.5"></i>Konfirmasi Keluar
                    </button>
                </form>
            </div>
        @empty
            <div class="p-8 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-300 flex items-center justify-center text-2xl mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-gray-500 text-xs font-semibold">Tidak ada siswa yang menunggu konfirmasi keluar</p>
            </div>
        @endforelse
    </div>

    {{-- DESKTOP: Tabel --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-[11px] uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4 text-left">No. Surat</th>
                    <th class="p-4 text-left">Nama Siswa</th>
                    <th class="p-4 text-left">Kelas</th>
                    <th class="p-4 text-left">Jam Keluar</th>
                    <th class="p-4 text-left">Jam Kembali</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($menungguKeluar as $s)
                    <tr class="hover:bg-blue-50/40 transition-colors">
                        <td class="p-4 font-mono font-bold text-xs">{{ $s->nomor_surat }}</td>
                        <td class="p-4 font-semibold">{{ $s->siswa->nama_lengkap }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $s->siswa->kelas->nama_kelas }} - {{ $s->siswa->kelas->jurusan->nama_jurusan }}</td>
                        <td class="p-4 font-medium text-blue-600">{{ $s->jam_keluar }}</td>
                        <td class="p-4 font-medium text-blue-600">{{ $s->jam_kembali }}</td>
                        <td class="p-4 text-center">
                            <form method="POST" action="{{ route('satpam.konfirmasi.keluar', $s) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        data-confirm="Konfirmasi {{ $s->siswa->nama_lengkap }} KELUAR dari sekolah?"
                                        class="px-3.5 py-2 rounded-xl bg-blue-600 hover:bg-blue-700 text-white text-xs font-bold transition-colors">
                                    <i class="fas fa-door-open mr-1"></i>Konfirmasi Keluar
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 text-sm">
                            <i class="fas fa-check-circle text-3xl text-emerald-300 mb-2"></i>
                            <p>Tidak ada siswa yang menunggu konfirmasi keluar</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

{{-- ============ SISWA SEDANG DI LUAR SEKOLAH ============ --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-4 py-3 sm:p-5 border-b border-gray-100 bg-sky-50/60 flex items-center justify-between gap-2">
        <div>
            <h3 class="text-sm font-bold text-sky-800">
                <i class="fas fa-person-walking mr-1.5"></i>Siswa Sedang di Luar Sekolah
            </h3>
            <p class="text-[11px] text-sky-600 mt-0.5">Sudah keluar, belum kembali.</p>
        </div>
        <span class="px-2.5 py-1 rounded-full bg-sky-500 text-white text-[10px] font-bold flex-shrink-0">
            {{ $siswaKeluar->count() }}
        </span>
    </div>

    {{-- MOBILE: Kartu --}}
    <div class="md:hidden divide-y divide-gray-100">
        @forelse($siswaKeluar as $s)
            <div class="p-4">
                <div class="flex justify-between items-start gap-2 mb-1">
                    <p class="font-mono font-bold text-gray-800 text-xs">{{ $s->nomor_surat }}</p>
                    <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-sky-100 text-sky-700 border border-sky-200">Di Luar</span>
                </div>
                <p class="font-bold text-gray-900 text-sm truncate">{{ $s->siswa->nama_lengkap }}</p>
                <p class="text-[11px] text-gray-500 truncate">{{ $s->siswa->kelas->nama_kelas }} • {{ $s->siswa->kelas->jurusan->nama_jurusan }}</p>

                <div class="grid grid-cols-2 gap-2 mt-2 text-[11px]">
                    <div class="px-2.5 py-1.5 rounded-lg bg-gray-50 border border-gray-100">
                        <p class="text-gray-400 text-[9px] font-bold uppercase">Keluar</p>
                        <p class="font-bold text-gray-800">{{ $s->waktu_keluar_aktual ? $s->waktu_keluar_aktual->format('H:i') : '-' }}</p>
                    </div>
                    <div class="px-2.5 py-1.5 rounded-lg bg-amber-50 border border-amber-100">
                        <p class="text-amber-500 text-[9px] font-bold uppercase">Batas Kembali</p>
                        <p class="font-bold text-amber-700">{{ $s->jam_kembali }}</p>
                    </div>
                </div>

                <p class="text-[11px] text-gray-500 mt-2 truncate">
                    <i class="fas fa-user-tie text-gray-400 mr-1"></i>
                    {{ $s->guruPiket->guru->nama_lengkap ?? 'Guru Piket tidak diketahui' }}
                </p>

                <form method="POST" action="{{ route('satpam.konfirmasi.kembali', $s) }}" class="mt-3">
                    @csrf
                    <button type="submit"
                            data-confirm="Konfirmasi {{ $s->siswa->nama_lengkap }} KEMBALI ke sekolah?"
                            class="w-full inline-flex justify-center items-center px-4 py-3 rounded-xl text-xs font-bold text-white bg-emerald-600 hover:bg-emerald-700 shadow-md shadow-emerald-500/20 active:scale-[0.98] transition-all">
                        <i class="fas fa-door-closed mr-1.5"></i>Konfirmasi Kembali
                    </button>
                </form>
            </div>
        @empty
            <div class="p-8 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-300 flex items-center justify-center text-2xl mb-3">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-gray-500 text-xs font-semibold">Tidak ada siswa yang sedang di luar sekolah</p>
            </div>
        @endforelse
    </div>

    {{-- DESKTOP: Tabel --}}
    <div class="hidden md:block overflow-x-auto">
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-[11px] uppercase tracking-wider text-gray-500">
                <tr>
                    <th class="p-4 text-left">Nama Siswa</th>
                    <th class="p-4 text-left">Kelas</th>
                    <th class="p-4 text-left">Keluar Aktual</th>
                    <th class="p-4 text-left">Batas Kembali</th>
                    <th class="p-4 text-left">Guru Piket</th>
                    <th class="p-4 text-center">Aksi</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100">
                @forelse($siswaKeluar as $s)
                    <tr class="hover:bg-blue-50/40 transition-colors">
                        <td class="p-4 font-semibold">{{ $s->siswa->nama_lengkap }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $s->siswa->kelas->nama_kelas }} - {{ $s->siswa->kelas->jurusan->nama_jurusan }}</td>
                        <td class="p-4">{{ $s->waktu_keluar_aktual ? $s->waktu_keluar_aktual->format('H:i') : '-' }}</td>
                        <td class="p-4 font-semibold text-amber-600">{{ $s->jam_kembali }}</td>
                        <td class="p-4 text-gray-500 text-xs">{{ $s->guruPiket->guru->nama_lengkap ?? '-' }}</td>
                        <td class="p-4 text-center">
                            <form method="POST" action="{{ route('satpam.konfirmasi.kembali', $s) }}" class="inline">
                                @csrf
                                <button type="submit"
                                        data-confirm="Konfirmasi {{ $s->siswa->nama_lengkap }} KEMBALI ke sekolah?"
                                        class="px-3.5 py-2 rounded-xl bg-emerald-600 hover:bg-emerald-700 text-white text-xs font-bold transition-colors">
                                    <i class="fas fa-door-closed mr-1"></i>Konfirmasi Kembali
                                </button>
                            </form>
                        </td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="6" class="p-8 text-center text-gray-500 text-sm">
                            <i class="fas fa-check-circle text-3xl text-emerald-300 mb-2"></i>
                            <p>Tidak ada siswa yang sedang di luar sekolah</p>
                        </td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

@push('scripts')
<script>
// Konfirmasi SweetAlert (menggantikan confirm() bawaan browser yang kaku)
document.querySelectorAll('[data-confirm]').forEach(btn => {
    btn.addEventListener('click', function (e) {
        e.preventDefault();
        const form = this.closest('form');
        const isKeluar = form.action.includes('keluar');

        Swal.fire({
            title: 'Konfirmasi Aksi',
            text: this.dataset.confirm,
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: isKeluar ? '#2563eb' : '#059669',
            cancelButtonColor: '#9ca3af',
            confirmButtonText: 'Ya, Konfirmasi',
            cancelButtonText: 'Batal',
            reverseButtons: true
        }).then(result => {
            if (result.isConfirmed) form.submit();
        });
    });
});
</script>
@endpush
@endsection