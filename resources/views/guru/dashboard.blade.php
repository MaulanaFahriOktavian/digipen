@extends('guru.layouts.app')

@section('title', 'Dashboard')
@section('page-title', 'Dashboard Guru Piket')

@section('content')

@php
    $firstName = explode(' ', auth()->user()->name)[0];
    // Format jam: Carbon → H:i | string datetime → ambil HH:MM | teks biasa → apa adanya
    $fmtTime = function ($v) {
        if ($v instanceof \Carbon\Carbon) return $v->format('H:i');
        return preg_match('/\d{2}:\d{2}/', (string) $v, $m) ? $m[0] : $v;
    };
    $pendingCount = $stats['pending'] ?? 0;
@endphp

{{-- ============ HERO (ringkas) ============ --}}
@if($stats['piket_hari_ini'] ?? null)
<div class="relative overflow-hidden rounded-2xl mb-4">
    <div class="absolute inset-0 bg-gradient-to-r from-blue-700 via-blue-600 to-sky-500"></div>
    <div class="absolute -top-16 -right-16 w-56 h-56 bg-white/10 rounded-full"></div>
    <div class="relative z-10 p-4 sm:p-6">
        <p class="text-blue-100 text-[10px] sm:text-[11px] font-bold uppercase tracking-widest">{{ now()->isoFormat('dddd, D MMMM Y') }}</p>
        <h2 class="text-lg sm:text-2xl font-black text-white tracking-tight mt-0.5">Halo, {{ $firstName }}! 👋</h2>
        <div class="mt-2.5">
            <span class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/15 border border-white/20 text-white text-[11px] font-bold">
                <i class="fas fa-clock mr-1.5 text-amber-300"></i>Shift {{ ucfirst($stats['piket_hari_ini']->shift) }}
            </span>
        </div>
    </div>
</div>
@else
<div class="bg-amber-50 border border-amber-200 rounded-2xl p-4 mb-4 flex items-center gap-3">
    <div class="w-10 h-10 rounded-xl bg-amber-500 text-white flex items-center justify-center flex-shrink-0">
        <i class="fas fa-exclamation-triangle"></i>
    </div>
    <div>
        <h3 class="text-sm font-bold text-amber-800">Tidak Ada Jadwal Piket</h3>
        <p class="text-xs text-amber-700 mt-0.5">Anda tidak piket hari ini.</p>
    </div>
</div>
@endif

{{-- ============ ALERT SISWA KELUAR (ringkas) ============ --}}
@if(isset($siswaKeluar) && $siswaKeluar->count() > 0)
<div class="bg-white rounded-2xl border-2 border-red-200 shadow-sm overflow-hidden mb-4">
    <div class="p-3.5 bg-gradient-to-r from-red-50 to-amber-50 flex items-center justify-between gap-2">
        <div class="flex items-center gap-2.5 min-w-0">
            <div class="w-9 h-9 rounded-xl bg-red-500 text-white flex items-center justify-center flex-shrink-0 animate-pulse">
                <i class="fas fa-triangle-exclamation text-sm"></i>
            </div>
            <p class="text-sm font-bold text-red-800 truncate">{{ $siswaKeluar->count() }} Siswa Sedang Keluar</p>
        </div>
    </div>
    <div class="divide-y divide-gray-100 max-h-56 overflow-y-auto">
        @foreach($siswaKeluar as $item)
            <div class="p-3.5 flex items-center justify-between gap-2">
                <div class="min-w-0">
                    <p class="font-bold text-gray-900 text-sm truncate">{{ $item->siswa->nama_lengkap }}</p>
                    <p class="text-[11px] text-gray-500 truncate">
                        {{ $item->siswa->kelas->nama_kelas }} • {{ $fmtTime($item->jam_keluar) }}–{{ $fmtTime($item->jam_kembali) }}
                    </p>
                </div>
                <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-red-100 text-red-700 border border-red-200 flex-shrink-0">Keluar</span>
            </div>
        @endforeach
    </div>
</div>
@endif

{{-- ============ STATISTIK (compact) ============ --}}
<div class="grid grid-cols-2 gap-2 sm:gap-4 mb-4 md:grid-cols-4">
    @php
        $cards = [
            ['Menunggu',       $pendingCount,            'fa-clock',         'bg-amber-100 text-amber-600',    'border-amber-400'],
            ['Sedang Keluar',  $stats['keluar'] ?? 0,    'fa-person-walking','bg-sky-100 text-sky-600',        'border-sky-400'],
            ['Selesai',        $stats['selesai'] ?? 0,   'fa-check-circle',  'bg-emerald-100 text-emerald-600','border-emerald-400'],
            ['Total Hari Ini', $stats['total'] ?? 0,     'fa-tasks',         'bg-blue-100 text-blue-600',      'border-blue-400'],
        ];
    @endphp
    @foreach($cards as [$label, $value, $icon, $color, $border])
        <div class="bg-white rounded-xl border border-gray-100 border-l-4 {{ $border }} shadow-sm p-3 sm:p-5 flex items-center justify-between gap-2">
            <div class="min-w-0">
                <p class="text-gray-500 text-[10px] sm:text-xs font-semibold truncate">{{ $label }}</p>
                <h3 class="text-xl sm:text-3xl font-black text-gray-800 mt-0.5">{{ $value }}</h3>
            </div>
            <div class="p-2 sm:p-3 rounded-lg sm:rounded-xl {{ $color }} flex-shrink-0">
                <i class="fas {{ $icon }} text-sm sm:text-lg"></i>
            </div>
        </div>
    @endforeach
</div>

{{-- ============ MENUNGGU PERSETUJUAN (ringkas) ============ --}}
<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Header: judul + count + link, tanpa subtitle --}}
    <div class="px-4 py-3 sm:p-5 border-b border-gray-100 flex items-center justify-between gap-2">
        <h3 class="text-sm font-bold text-gray-900 flex items-center">
            <i class="fas fa-list mr-1.5 text-blue-600"></i>Menunggu Persetujuan
            @if($pendingCount > 0)
                <span class="ml-2 px-2 py-0.5 rounded-full bg-amber-500 text-white text-[10px] font-bold">{{ $pendingCount }}</span>
            @endif
        </h3>
        @if(isset($pendingDispensasi) && $pendingDispensasi->count() > 0)
            <a href="{{ route('guru.pengajuan.index') }}" class="text-[11px] font-bold text-blue-600 flex-shrink-0">Lihat Semua →</a>
        @endif
    </div>

    {{-- MOBILE: baris ringkas --}}
    <div class="md:hidden divide-y divide-gray-100">
        @if(isset($pendingDispensasi) && $pendingDispensasi->count() > 0)
            @foreach($pendingDispensasi->take(5) as $item)
                <div class="p-3.5">
                    <div class="flex items-center justify-between gap-2">
                        <p class="font-bold text-gray-900 text-sm truncate">{{ $item->siswa->nama_lengkap }}</p>
                        <span class="px-2 py-0.5 rounded-full text-[10px] font-bold bg-amber-100 text-amber-700 border border-amber-200 flex-shrink-0">Menunggu</span>
                    </div>
                    <p class="text-[11px] text-gray-500 truncate mt-0.5">
                        {{ $item->siswa->kelas->nama_kelas }} • {{ ucfirst(str_replace('_', ' ', $item->kategori)) }} • {{ $fmtTime($item->jam_keluar) }}–{{ $fmtTime($item->jam_kembali) }}
                    </p>
                    <a href="{{ route('guru.pengajuan.show', $item) }}"
                       class="mt-2.5 w-full inline-flex justify-center items-center px-4 py-2 rounded-xl text-[11px] font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-md shadow-blue-500/20 active:scale-[0.98] transition-all">
                        Proses <i class="fas fa-arrow-right ml-1.5 text-[10px]"></i>
                    </a>
                </div>
            @endforeach
        @else
            <div class="p-8 text-center">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-300 flex items-center justify-center text-xl mb-2">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-gray-500 font-semibold text-sm">Semua pengajuan sudah diproses</p>
            </div>
        @endif
    </div>

    {{-- DESKTOP: list lengkap --}}
    <div class="hidden md:block p-5">
        @if(isset($pendingDispensasi) && $pendingDispensasi->count() > 0)
            <div class="space-y-3">
                @foreach($pendingDispensasi->take(5) as $item)
                    <div class="border border-gray-100 rounded-xl p-4 hover:border-blue-200 hover:bg-blue-50/30 transition-all flex items-center justify-between gap-4">
                        <div class="min-w-0">
                            <h4 class="font-semibold text-gray-900 truncate">{{ $item->siswa->nama_lengkap }}</h4>
                            <p class="text-xs text-gray-500 truncate mt-0.5">
                                {{ $item->siswa->kelas->nama_kelas }} • {{ ucfirst(str_replace('_', ' ', $item->kategori)) }} •
                                {{ $fmtTime($item->jam_keluar) }}–{{ $fmtTime($item->jam_kembali) }} • {{ $item->tujuan }}
                            </p>
                        </div>
                        <a href="{{ route('guru.pengajuan.show', $item) }}"
                           class="inline-flex items-center px-4 py-2 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-md shadow-blue-500/20 transition-all flex-shrink-0">
                            <i class="fas fa-eye mr-1.5"></i>Proses
                        </a>
                    </div>
                @endforeach
            </div>
        @else
            <div class="text-center py-10">
                <div class="w-14 h-14 mx-auto rounded-2xl bg-emerald-50 text-emerald-300 flex items-center justify-center text-xl mb-2">
                    <i class="fas fa-check-circle"></i>
                </div>
                <p class="text-gray-500 font-semibold text-sm">Semua pengajuan sudah diproses</p>
            </div>
        @endif
    </div>
</div>
@endsection