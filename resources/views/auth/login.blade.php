<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login — DIDISPEN</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
    <style>
        .ripple {
            position: absolute;
            border-radius: 50%;
            transform: scale(0);
            animation: ripple 0.6s linear;
            background-color: rgba(255, 255, 255, 0.4);
            pointer-events: none;
        }
        @keyframes ripple {
            to { transform: scale(4); opacity: 0; }
        }
        .glass {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
        }
        @keyframes fade-in-up {
            from { opacity: 0; transform: translateY(10px); }
            to { opacity: 1; transform: translateY(0); }
        }
        .animate-fade-in-up {
            animation: fade-in-up 0.4s ease-out;
        }
        input[type="date"]::-webkit-calendar-picker-indicator {
            opacity: 0.5;
            cursor: pointer;
        }
    </style>
</head>
<body class="bg-gray-100">
    <div class="min-h-screen flex" x-data="loginForm()">
        
        <!-- ============================================ -->
        <!-- LEFT SIDE: BRANDING & FEATURES (55%) -->
        <!-- ============================================ -->
        <div class="hidden lg:flex lg:w-[55%] relative overflow-hidden">
            
            <!-- LAYER 1: BACKGROUND FOTO SMK -->
            <div class="absolute inset-0">
                <img 
                    src="{{ asset('images/fotosmk.PNG') }}" 
                    alt="Gedung Sekolah SMK"
                    class="w-full h-full object-cover"
                    style="transform: scale(1.05);"
                >
            </div>
            
            <!-- LAYER 2: GRADIENT OVERLAY BIRU -->
            <div class="absolute inset-0 bg-gradient-to-br from-blue-950/85 via-blue-900/70 to-sky-900/85"></div>
            
            <!-- LAYER 3: NOISE PATTERN -->
            <div class="absolute inset-0 opacity-[0.04]" style="background-image: url('data:image/svg+xml,%3Csvg viewBox=%220 0 200 200%22 xmlns=%22http://www.w3.org/2000/svg%22%3E%3Cfilter id=%22noiseFilter%22%3E%3CfeTurbulence type=%22fractalNoise%22 baseFrequency=%220.9%22 numOctaves=%224%22 stitchTiles=%22stitch%22/%3E%3C/filter%3E%3Crect width=%22100%25%22 height=%22100%25%22 filter=%22url(%23noiseFilter)%22/%3E%3C/svg%3E');"></div>
            
            <!-- LAYER 4: GLOW EFFECTS (BIRU SEMUA) -->
            <div class="absolute top-0 left-0 w-[500px] h-[500px] bg-blue-500/25 rounded-full blur-[100px] -translate-x-1/3 -translate-y-1/3"></div>
            <div class="absolute bottom-0 right-0 w-[400px] h-[400px] bg-blue-400/20 rounded-full blur-[80px] translate-x-1/4 translate-y-1/4"></div>

            <!-- Content -->
            <div class="relative z-20 flex flex-col justify-between w-full px-10 xl:px-14 py-8">
                
                <!-- Header -->
                <div class="space-y-4">
                    <div class="flex items-center space-x-3">
                        <!-- LOGO SEKOLAH -->
                        <div class="relative">
                            <div class="absolute inset-0 bg-blue-400/50 rounded-2xl blur-xl"></div>
                            <div class="relative flex items-center justify-center w-11 h-11 rounded-2xl bg-white/10 backdrop-blur-2xl border border-white/25 p-1.5">
                                <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                            </div>
                        </div>
                        <div>
                            <h1 class="text-white font-bold text-base tracking-tight">SMK NEGERI 1</h1>
                            <p class="text-white/70 text-[11px] font-medium tracking-wide">Sistem Informasi Dispensasi Digital</p>
                        </div>
                    </div>

                    <div class="inline-flex items-center px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-2xl border border-white/20">
                        <span class="relative flex h-2 w-2 mr-2">
                          <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-emerald-400 opacity-75"></span>
                          <span class="relative inline-flex rounded-full h-2 w-2 bg-emerald-400"></span>
                        </span>
                        <span class="text-white text-xs font-semibold">Sistem Online</span>
                    </div>
                </div>

                <!-- Hero Section -->
                <div class="space-y-5 max-w-xl">
                    <div class="space-y-3">
                        <div class="inline-flex items-center px-3 py-1 rounded-full bg-blue-400/10 backdrop-blur-xl border border-blue-300/20">
                            <span class="text-blue-300 text-[11px] font-semibold tracking-widest uppercase">School Management Platform</span>
                        </div>
                        <h2 class="text-5xl xl:text-6xl font-black text-white leading-none tracking-tighter">
                            DIDISPEN
                        </h2>
                        <div class="space-y-0.5">
                            <h3 class="text-xl xl:text-2xl font-bold text-white/95 leading-tight">Digital School</h3>
                            <h3 class="text-xl xl:text-2xl font-bold text-blue-300 leading-tight">Dispensation System</h3>
                        </div>
                        <p class="text-white/75 text-sm leading-relaxed max-w-md pt-2">
                            Sistem informasi dispensasi sekolah berbasis digital yang membantu proses perizinan siswa menjadi lebih cepat, aman, terdokumentasi, dan terintegrasi.
                        </p>
                    </div>

                    <!-- Feature Cards -->
                    <div class="grid grid-cols-3 gap-3 pt-4">
                        <div class="group relative overflow-hidden rounded-2xl bg-white/[0.08] backdrop-blur-2xl border border-white/15 p-4 hover:bg-white/[0.12] hover:border-white/30 hover:-translate-y-1 transition-all duration-300">
                            <div class="relative space-y-2">
                                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-emerald-400/20 text-emerald-300 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h3 class="text-white font-bold text-xs">Aman</h3>
                                    <p class="text-white/60 text-[10px]">Database Terenkripsi</p>
                                </div>
                                <div class="h-px bg-gradient-to-r from-white/20 to-transparent"></div>
                                <p class="text-white/50 text-[10px] leading-relaxed">Keamanan data berlapis</p>
                            </div>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl bg-white/[0.08] backdrop-blur-2xl border border-white/15 p-4 hover:bg-white/[0.12] hover:border-white/30 hover:-translate-y-1 transition-all duration-300">
                            <div class="relative space-y-2">
                                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-blue-400/20 text-blue-300 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v1m6 11h2m-6 0h-2v4m0-11v3m0 0h.01M12 12h4.01M16 20h4M4 12h4m12 0h.01M5 8h2a1 1 0 001-1V5a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1zm12 0h2a1 1 0 001-1V5a1 1 0 00-1-1h-2a1 1 0 00-1 1v2a1 1 0 001 1zM5 20h2a1 1 0 001-1v-2a1 1 0 00-1-1H5a1 1 0 00-1 1v2a1 1 0 001 1z"/></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h3 class="text-white font-bold text-xs">Verifikasi QR</h3>
                                    <p class="text-white/60 text-[10px]">Validasi QR Code</p>
                                </div>
                                <div class="h-px bg-gradient-to-r from-white/20 to-transparent"></div>
                                <p class="text-white/50 text-[10px] leading-relaxed">Anti pemalsuan surat</p>
                            </div>
                        </div>

                        <div class="group relative overflow-hidden rounded-2xl bg-white/[0.08] backdrop-blur-2xl border border-white/15 p-4 hover:bg-white/[0.12] hover:border-white/30 hover:-translate-y-1 transition-all duration-300">
                            <div class="relative space-y-2">
                                <div class="flex items-center justify-center w-9 h-9 rounded-xl bg-sky-400/25 text-sky-300 group-hover:scale-110 transition-transform duration-300">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                                </div>
                                <div class="space-y-0.5">
                                    <h3 class="text-white font-bold text-xs">Realtime Monitor</h3>
                                    <p class="text-white/60 text-[10px]">Live Tracking</p>
                                </div>
                                <div class="h-px bg-gradient-to-r from-white/20 to-transparent"></div>
                                <p class="text-white/50 text-[10px] leading-relaxed">Pantau status langsung</p>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Footer -->
                <div class="space-y-2">
                    <div class="flex items-center justify-between">
                        <div>
                            <p class="text-white font-bold text-xs">DIDISPEN</p>
                            <p class="text-white/60 text-[10px]">Version 2.0</p>
                        </div>
                        <div class="px-3 py-1.5 rounded-full bg-white/10 backdrop-blur-2xl border border-white/20">
                            <span class="text-white/80 text-[10px] font-semibold">Powered by DIDISPEN</span>
                        </div>
                    </div>
                    <div class="h-px bg-gradient-to-r from-white/20 via-white/10 to-transparent"></div>
                    <p class="text-white/40 text-[10px]">© 2026 All rights reserved</p>
                </div>
            </div>
        </div>

        <!-- ============================================ -->
        <!-- RIGHT SIDE: LOGIN FORM (45%) -->
        <!-- ============================================ -->
        <div class="flex-1 flex items-center justify-center p-6 sm:p-8 lg:p-10 bg-gradient-to-br from-gray-50 via-white to-blue-50/30">
            <div class="w-full max-w-md">
                
                <!-- MOBILE LOGO -->
                <div class="lg:hidden flex items-center justify-center mb-6">
                    <div class="flex items-center space-x-3">
                        <div class="flex items-center justify-center w-12 h-12 rounded-2xl bg-white shadow-lg shadow-blue-200 p-1.5 border border-blue-100">
                            <img src="{{ asset('images/logo.png') }}" alt="Logo Sekolah" class="w-full h-full object-contain">
                        </div>
                        <div>
                            <h1 class="text-gray-900 font-bold text-base">DIDISPEN</h1>
                            <p class="text-gray-500 text-[11px]">Sistem Informasi Dispensasi Digital</p>
                        </div>
                    </div>
                </div>

                <!-- Welcome Text -->
                <div class="mb-5 text-center lg:text-left">
                    <h2 class="text-2xl font-bold text-gray-900 tracking-tight mb-1">Selamat Datang</h2>
                    <p class="text-gray-500 text-sm">Silakan pilih peran Anda untuk mengakses DIDISPEN</p>
                </div>

                <!-- Role Selector -->
                <div class="grid grid-cols-3 gap-2 mb-5">
                    <template x-for="role in roles" :key="role.id">
                        <button
                            type="button"
                            @click="activeRole = role.id"
                            class="relative flex flex-col items-center justify-center py-3.5 px-2 rounded-xl border-2 transition-all duration-300 group"
                            :class="activeRole === role.id 
                                ? 'bg-gradient-to-br from-blue-50 to-sky-100 border-blue-600 text-blue-600 shadow-lg shadow-blue-200 scale-105' 
                                : 'bg-white border-gray-100 text-gray-400 hover:border-gray-200 hover:text-gray-600 hover:shadow-md hover:-translate-y-0.5'"
                        >
                            <div class="mb-1.5 transition-all duration-300" :class="activeRole === role.id ? 'scale-110' : 'scale-100 group-hover:scale-105'" x-html="role.icon"></div>
                            <span class="text-xs font-bold" x-text="role.label"></span>
                            <div class="absolute -bottom-1 left-1/2 -translate-x-1/2 w-6 h-1 rounded-full transition-all duration-300" :class="activeRole === role.id ? 'bg-blue-600 opacity-100' : 'bg-transparent opacity-0'"></div>
                        </button>
                    </template>
                </div>

                <!-- Login Card -->
                <div class="relative">
                    <div class="absolute -inset-1 bg-gradient-to-r from-blue-600 via-sky-500 to-blue-600 rounded-3xl opacity-15 blur-2xl transition-opacity duration-700"></div>
                    
                    <div class="relative glass rounded-2xl p-5 border border-gray-100 shadow-2xl shadow-blue-200/30">
                        
                        <!-- Card Header -->
                        <div class="mb-5 flex items-center space-x-3 pb-4 border-b border-gray-100">
                            <div class="relative">
                                <div class="absolute inset-0 bg-gradient-to-br from-blue-600 to-sky-500 rounded-xl blur-md opacity-60"></div>
                                <div class="relative flex items-center justify-center w-11 h-11 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 shadow-lg shadow-blue-500/40 transition-all duration-300" x-html="getActiveRole().iconLarge"></div>
                            </div>
                            <div>
                                <h3 class="font-bold text-gray-900 text-sm" x-text="'Login sebagai ' + getActiveRole().label"></h3>
                                <p class="text-xs text-gray-500 mt-0.5" x-text="getActiveRole().description"></p>
                            </div>
                        </div>

                        <!-- Error Alert -->
                        @if ($errors->any())
                            <div class="mb-4 p-3 rounded-xl bg-red-50 border border-red-200 flex items-start space-x-3 animate-fade-in-up">
                                <svg class="w-4 h-4 text-red-600 flex-shrink-0 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/>
                                </svg>
                                <div>
                                    <h4 class="text-sm font-bold text-red-600">Login Gagal</h4>
                                    <p class="text-sm text-red-600/80 mt-0.5">{{ $errors->first() }}</p>
                                </div>
                            </div>
                        @endif

                        <!-- ========================================== -->
                        <!-- FORM SISWA (NIS & Tanggal Lahir) -->
                        <!-- ========================================== -->
                        <form x-show="activeRole === 'student'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" method="POST" action="{{ route('login') }}" class="space-y-3.5" @submit="loading = true">
                            @csrf
                            <input type="hidden" name="role" value="siswa">
                            
                            <div class="group">
                                <label for="student_nis" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">NIS (Nomor Induk Siswa)</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H5a2 2 0 00-2 2v9a2 2 0 002 2h14a2 2 0 002-2V8a2 2 0 00-2-2h-5m-4 0V5a2 2 0 114 0v1m-4 0h4m-2 6h.01M12 15h.01"/>
                                        </svg>
                                    </div>
                                    <input id="student_nis" name="nis" type="text" value="{{ old('nis') }}" required autofocus placeholder="Masukkan NIS Anda" class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                            </div>

                            <div class="group">
                                <label for="student_tanggal_lahir" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Tanggal Lahir</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                                        </svg>
                                    </div>
                                    <input id="student_tanggal_lahir" name="tanggal_lahir" type="date" value="{{ old('tanggal_lahir') }}" required class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                            </div>

                            <button type="submit" :disabled="loading" @click="createRipple($event)" class="group relative w-full flex justify-center items-center h-[50px] px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden">
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-show="!loading" class="flex items-center">
                                    Masuk sebagai Siswa
                                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                        </form>

                        <!-- ========================================== -->
                        <!-- FORM GURU / ADMIN (Username & Password) -->
                        <!-- ========================================== -->
                        <form x-show="activeRole === 'teacher'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" method="POST" action="{{ route('login') }}" class="space-y-3.5" @submit="loading = true">
                            @csrf
                            <input type="hidden" name="role" value="guru">
                            
                            <div class="group">
                                <label for="teacher_username" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Username / NIP</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input id="teacher_username" name="username" type="text" value="{{ old('username') }}" required autofocus placeholder="Masukkan username atau NIP" class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                                <p class="text-xs text-gray-400 mt-1.5 ml-1">Administrator juga dapat login melalui form ini.</p>
                            </div>

                            <div class="group">
                                <label for="teacher_password" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input id="teacher_password" name="password" type="password" required placeholder="••••••••" class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                            </div>

                            <button type="submit" :disabled="loading" @click="createRipple($event)" class="group relative w-full flex justify-center items-center h-[50px] px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden">
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-show="!loading" class="flex items-center">
                                    Masuk sebagai Guru / Admin
                                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                        </form>

                        <!-- ========================================== -->
                        <!-- FORM SATPAM (Username & Password) -->
                        <!-- ========================================== -->
                        <form x-show="activeRole === 'security'" x-transition:enter="transition ease-out duration-300" x-transition:enter-start="opacity-0 translate-y-4" x-transition:enter-end="opacity-100 translate-y-0" method="POST" action="{{ route('login') }}" class="space-y-3.5" @submit="loading = true">
                            @csrf
                            <input type="hidden" name="role" value="satpam">
                            
                            <div class="group">
                                <label for="security_username" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Username</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>
                                        </svg>
                                    </div>
                                    <input id="security_username" name="username" type="text" value="{{ old('username') }}" required autofocus placeholder="Masukkan username" class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                            </div>

                            <div class="group">
                                <label for="security_password" class="block text-sm font-semibold text-gray-700 mb-1.5 transition-colors group-focus-within:text-blue-600">Password</label>
                                <div class="relative">
                                    <div class="absolute inset-y-0 left-0 pl-3.5 flex items-center pointer-events-none">
                                        <svg class="h-5 w-5 text-gray-400 group-focus-within:text-blue-600 transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/>
                                        </svg>
                                    </div>
                                    <input id="security_password" name="password" type="password" required placeholder="••••••••" class="block w-full h-[50px] pl-11 pr-4 rounded-xl border-2 border-gray-200 bg-white text-gray-900 placeholder-gray-400 focus:outline-none focus:ring-4 focus:ring-blue-100 focus:border-blue-600 transition-all duration-200 text-sm font-medium">
                                </div>
                            </div>

                            <button type="submit" :disabled="loading" @click="createRipple($event)" class="group relative w-full flex justify-center items-center h-[50px] px-4 border border-transparent rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 focus:outline-none focus:ring-4 focus:ring-blue-300 shadow-lg shadow-blue-500/30 hover:shadow-xl hover:shadow-blue-500/40 hover:-translate-y-0.5 active:translate-y-0 transition-all duration-200 disabled:opacity-70 disabled:cursor-not-allowed overflow-hidden">
                                <svg x-show="loading" class="animate-spin -ml-1 mr-2 h-5 w-5 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                <span x-show="!loading" class="flex items-center">
                                    Masuk sebagai Satpam
                                    <svg class="ml-2 w-4 h-4 group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/>
                                    </svg>
                                </span>
                                <span x-show="loading">Memproses...</span>
                            </button>
                        </form>

                        <!-- Demo Accounts -->
                        <!-- Demo Accounts -->
                        <div class="mt-4 pt-4 border-t border-gray-100">
                            <button @click="showDemo = !showDemo" class="w-full flex items-center justify-between text-xs font-medium text-gray-500 hover:text-blue-600 transition-colors">
                                <span>Lihat Akun Demo</span>
                                <svg class="w-4 h-4 transition-transform" :class="showDemo ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                                </svg>
                            </button>
                            <div x-show="showDemo" x-transition class="mt-3 space-y-2 text-xs text-gray-600 bg-gray-50 p-3 rounded-lg border border-gray-200">
                                <p class="font-semibold text-gray-800">🔑 Kredensial Login (Sesuai Database):</p>
                                <ul class="space-y-1.5">
                                    <li>👨‍🎓 <strong>Siswa:</strong> NIS <span class="font-mono text-red-600">12345</span> | Tgl Lahir <span class="font-mono text-red-600">2000-01-01</span></li>
                                    <li>👨‍💼 <strong>Admin:</strong> Username <span class="font-mono text-red-600">admin</span> | Pass <span class="font-mono text-red-600">admin123</span></li>
                                    <li>👨‍🏫 <strong>Guru 1:</strong> Username <span class="font-mono text-red-600">budi</span> | Pass <span class="font-mono text-red-600">password</span></li>
                                    <li>👩‍🏫 <strong>Guru 2:</strong> Username <span class="font-mono text-red-600">siti</span> | Pass <span class="font-mono text-red-600">password</span></li>
                                    <li>👮 <strong>Satpam:</strong> Username <span class="font-mono text-red-600">satpam</span> | Pass <span class="font-mono text-red-600">satpam123</span></li>
                                </ul>
                            </div>
                        </div>

                        <!-- Footer -->
                        <div class="mt-4 pt-4 border-t border-gray-100 text-center">
                            <a href="#" class="text-xs font-medium text-gray-500 hover:text-blue-600 transition-colors">Butuh bantuan? Hubungi Administrator</a>
                        </div>
                    </div>
                </div>

                <!-- Mobile Footer -->
                <div class="lg:hidden mt-6 text-center text-xs text-gray-400">
                    <p>© 2026 DIDISPEN v2.0</p>
                </div>
            </div>
        </div>
    </div>

    <script>
        function loginForm() {
            return {
                activeRole: 'student',
                loading: false,
                showDemo: false,
                roles: [
                    {
                        id: 'student', 
                        label: 'Siswa', 
                        description: 'Login menggunakan NIS dan Tanggal Lahir', // ✅ Diperbarui
                        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>`,
                        iconLarge: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l9-5-9-5-9 5 9 5z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 14l6.16-3.422a12.083 12.083 0 01.665 6.479A11.952 11.952 0 0012 20.055a11.952 11.952 0 00-6.824-2.998 12.078 12.078 0 01.665-6.479L12 14z"/></svg>`
                    },
                    {
                        id: 'teacher', 
                        label: 'Guru / Admin', // ✅ Diperbarui
                        description: 'Login menggunakan Username dan Password',
                        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>`,
                        iconLarge: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>`
                    },
                    {
                        id: 'security', 
                        label: 'Satpam', 
                        description: 'Login untuk monitoring gerbang',
                        icon: `<svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`,
                        iconLarge: `<svg class="w-6 h-6 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/></svg>`
                    }
                ],
                getActiveRole() {
                    return this.roles.find(r => r.id === this.activeRole);
                },
                createRipple(event) {
                    const button = event.currentTarget;
                    const circle = document.createElement('span');
                    const diameter = Math.max(button.clientWidth, button.clientHeight);
                    const radius = diameter / 2;
                    
                    circle.style.width = circle.style.height = `${diameter}px`;
                    circle.style.left = `${event.clientX - button.getBoundingClientRect().left - radius}px`;
                    circle.style.top = `${event.clientY - button.getBoundingClientRect().top - radius}px`;
                    circle.classList.add('ripple');
                    
                    const existingRipple = button.querySelector('.ripple');
                    if (existingRipple) {
                        existingRipple.remove();
                    }
                    
                    button.appendChild(circle);
                    setTimeout(() => circle.remove(), 600);
                }
            }
        }
    </script>
</body>
</html>