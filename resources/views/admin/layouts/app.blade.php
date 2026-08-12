<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') - DIDISPEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-gray-100">
@php
    $user   = auth()->user();
    $navOn  = 'flex items-center w-full px-4 py-2.5 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-lg shadow-blue-500/30';
    $navOff = 'flex items-center w-full px-4 py-2.5 rounded-xl text-sm font-semibold text-gray-600 hover:bg-blue-50 hover:text-blue-700 transition-colors';
@endphp
<div class="flex h-screen overflow-hidden" x-data="{ open: false }">

    {{-- ============ SIDEBAR ============ --}}
    <aside :class="open ? 'translate-x-0' : '-translate-x-full'"
           class="fixed lg:static z-40 inset-y-0 left-0 w-72 bg-white border-r border-gray-200 flex flex-col transition-transform duration-200 lg:translate-x-0">

        {{-- Brand --}}
        <div class="flex items-center space-x-3 px-5 py-5 border-b border-gray-100">
            <div class="relative">
                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-sky-500 rounded-xl blur-md opacity-40"></div>
                <div class="relative flex items-center justify-center w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 text-white shadow-lg shadow-blue-500/40">
                    <i class="fas fa-school"></i>
                </div>
            </div>
            <div>
                <h1 class="text-base font-bold text-gray-900 tracking-tight">DIDISPEN</h1>
                <p class="text-[11px] text-gray-500 font-medium">Panel Administrator</p>
            </div>
        </div>

        {{-- Navigasi --}}
        <nav class="flex-1 overflow-y-auto px-4 py-4">
            <a href="{{ route('admin.dashboard') }}" class="{{ request()->routeIs('admin.dashboard') ? $navOn : $navOff }}">
                <i class="fas fa-tachometer-alt w-5 mr-3 text-center"></i> Dashboard
            </a>

            <p class="px-4 mb-2 mt-5 text-[11px] font-bold uppercase tracking-wider text-gray-400">Master Data</p>
            <div class="space-y-1">
                <a href="{{ route('admin.jurusan.index') }}" class="{{ request()->routeIs('admin.jurusan.*') ? $navOn : $navOff }}">
                    <i class="fas fa-graduation-cap w-5 mr-3 text-center"></i> Jurusan
                </a>
                <a href="{{ route('admin.kelas.index') }}" class="{{ request()->routeIs('admin.kelas.*') ? $navOn : $navOff }}">
                    <i class="fas fa-chalkboard w-5 mr-3 text-center"></i> Kelas
                </a>
                <a href="{{ route('admin.siswa.index') }}" class="{{ request()->routeIs('admin.siswa.*') ? $navOn : $navOff }}">
                    <i class="fas fa-user-graduate w-5 mr-3 text-center"></i> Siswa
                </a>
                <a href="{{ route('admin.guru.index') }}" class="{{ (request()->routeIs('admin.guru.index') || request()->routeIs('admin.guru.create') || request()->routeIs('admin.guru.edit')) ? $navOn : $navOff }}">
                    <i class="fas fa-chalkboard-teacher w-5 mr-3 text-center"></i> Guru
                </a>
                <a href="{{ route('admin.guru.checklog') }}" class="{{ request()->routeIs('admin.guru.checklog') ? $navOn : $navOff }}">
                    <i class="fas fa-id-card-alt w-5 mr-3 text-center"></i> Izin Guru
                </a>
            </div>

            <p class="px-4 mb-2 mt-5 text-[11px] font-bold uppercase tracking-wider text-gray-400">Operasional</p>
            <div class="space-y-1">
                <a href="{{ route('admin.piket.index') }}" class="{{ request()->routeIs('admin.piket.*') ? $navOn : $navOff }}">
                    <i class="fas fa-calendar-alt w-5 mr-3 text-center"></i> Jadwal Piket
                </a>
                <a href="{{ route('admin.semua.pengajuan') }}" class="{{ request()->routeIs('admin.semua.*') ? $navOn : $navOff }}">
                    <i class="fas fa-file-alt w-5 mr-3 text-center"></i> Semua Pengajuan
                </a>
                <a href="{{ route('admin.laporan.index') }}" class="{{ request()->routeIs('admin.laporan.*') ? $navOn : $navOff }}">
                    <i class="fas fa-chart-bar w-5 mr-3 text-center"></i> Laporan
                </a>
            </div>

            <p class="px-4 mb-2 mt-5 text-[11px] font-bold uppercase tracking-wider text-gray-400">Sistem</p>
            <div class="space-y-1">
                <a href="{{ route('admin.settings.index') }}" class="{{ request()->routeIs('admin.settings.*') ? $navOn : $navOff }}">
                    <i class="fas fa-cog w-5 mr-3 text-center"></i> Pengaturan
                </a>
                <a href="{{ route('admin.audit.index') }}" class="{{ request()->routeIs('admin.audit.*') ? $navOn : $navOff }}">
                    <i class="fas fa-history w-5 mr-3 text-center"></i> Audit Log
                </a>
            </div>
        </nav>

        {{-- Logout --}}
        <div class="p-4 border-t border-gray-100">
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button type="submit" class="w-full flex items-center justify-center px-4 py-2.5 rounded-xl text-sm font-bold text-red-600 border border-red-200 hover:bg-red-50 transition-colors">
                    <i class="fas fa-sign-out-alt mr-2"></i> Logout
                </button>
            </form>
        </div>
    </aside>

    {{-- Overlay Mobile --}}
    <div x-show="open" x-cloak @click="open = false" class="fixed inset-0 bg-black/40 z-30 lg:hidden" style="display:none"></div>

    {{-- ============ KONTEN ============ --}}
    <div class="flex-1 flex flex-col overflow-hidden">

        {{-- Topbar --}}
        <header class="bg-white border-b border-gray-200 px-6 py-3 flex items-center justify-between">
            <div class="flex items-center space-x-3">
                <button @click="open = true" class="lg:hidden w-9 h-9 rounded-lg border border-gray-200 text-gray-600 hover:bg-gray-50">
                    <i class="fas fa-bars"></i>
                </button>
                <h2 class="text-base font-bold text-gray-900">@yield('page-title', 'Dashboard')</h2>
            </div>
            <div class="flex items-center space-x-3">
                <span class="hidden sm:flex items-center text-xs font-semibold text-gray-500">
                    <i class="far fa-calendar mr-1.5 text-blue-600"></i> {{ now()->format('d M Y') }}
                </span>
                <div class="h-6 w-px bg-gray-200"></div>
                <div class="flex items-center space-x-2.5">
                    <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-600 to-sky-500 text-white text-sm font-bold flex items-center justify-center shadow-md shadow-blue-500/30">
                        {{ strtoupper(substr($user->name, 0, 1)) }}
                    </div>
                    <div class="hidden md:block leading-tight">
                        <p class="text-sm font-bold text-gray-900">{{ $user->name }}</p>
                        <p class="text-[11px] text-blue-600 font-semibold">Administrator</p>
                    </div>
                </div>
            </div>
        </header>

        {{-- Konten (background senada sisi kanan login) --}}
        <main class="flex-1 overflow-y-auto p-6 bg-gradient-to-br from-gray-50 via-white to-blue-50/40">
            @yield('content')
        </main>
    </div>
</div>

@stack('scripts')

@if(session('success'))
<script>Swal.fire({ icon:'success', title:'Berhasil!', text:'{{ session('success') }}', timer:3000, showConfirmButton:false, position:'top-end', toast:true });</script>
@endif
@if(session('error'))
<script>Swal.fire({ icon:'error', title:'Gagal!', text:'{{ session('error') }}', timer:4000, showConfirmButton:false, position:'top-end', toast:true });</script>
@endif
</body>
</html>