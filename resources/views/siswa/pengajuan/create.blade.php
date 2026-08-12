@extends('siswa.layouts.app')

@section('title', 'Buat Pengajuan')
@section('page-title', 'Buat Pengajuan Dispensasi')

@section('content')

<div class="max-w-3xl mx-auto">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

        {{-- Header --}}
        <div class="px-4 py-4 sm:px-6 sm:py-5 border-b border-gray-100 flex items-center space-x-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 text-white flex items-center justify-center shadow-md shadow-blue-500/30 flex-shrink-0">
                <i class="fas fa-file-circle-plus text-sm"></i>
            </div>
            <div>
                <h3 class="text-sm sm:text-base font-bold text-gray-900">Form Pengajuan Dispensasi</h3>
                <p class="text-[11px] text-gray-500">Lengkapi data dengan benar.</p>
            </div>
        </div>

        <div class="p-4 sm:p-6">
            @if($errors->any())
                <div class="mb-4 p-3.5 rounded-xl bg-red-50 border border-red-200 text-xs text-red-700">
                    <p class="font-bold mb-1"><i class="fas fa-exclamation-circle mr-1"></i>Periksa kembali formulir Anda:</p>
                    <ul class="list-disc list-inside space-y-0.5">
                        @foreach($errors->all() as $error)<li>{{ $error }}</li>@endforeach
                    </ul>
                </div>
            @endif

            @if(!isset($guruPiketHariIni))
                <div class="p-5 rounded-xl bg-red-50 border border-red-200 text-center">
                    <i class="fas fa-user-slash text-3xl text-red-400 mb-3"></i>
                    <p class="text-red-700 font-semibold text-sm">Maaf, tidak ada guru piket yang bertugas hari ini.<br>Silakan hubungi Admin sekolah.</p>
                </div>
            @else
                <form method="POST" action="{{ route('siswa.pengajuan.store') }}" class="space-y-4">
                    @csrf

                    {{-- Data Siswa --}}
                    <div class="bg-gray-50 border border-gray-100 rounded-xl p-3.5 sm:p-4">
                        <h4 class="text-[10px] font-bold uppercase tracking-wider text-gray-400 mb-2.5">Data Siswa</h4>
                        <div class="grid grid-cols-1 sm:grid-cols-3 gap-2.5 text-xs">
                            <div>
                                <span class="text-gray-500 block mb-0.5">Nama Lengkap</span>
                                <span class="font-bold text-gray-800">{{ $siswa->nama_lengkap }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block mb-0.5">NIS / NISN</span>
                                <span class="font-mono font-bold text-gray-800">{{ $siswa->user->nis_nip ?? '-' }}</span>
                            </div>
                            <div>
                                <span class="text-gray-500 block mb-0.5">Kelas</span>
                                <span class="font-bold text-gray-800">{{ $siswa->kelas->nama_kelas }} — {{ $siswa->kelas->jurusan->nama_jurusan }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- Guru Piket --}}
                    <div class="bg-blue-50/70 border border-blue-100 rounded-xl p-3.5 flex items-center space-x-3">
                        <div class="w-9 h-9 rounded-full bg-blue-600 text-white flex items-center justify-center font-bold text-sm shadow-md shadow-blue-500/30 flex-shrink-0">
                            {{ strtoupper(substr($guruPiketHariIni->guru->nama_lengkap, 0, 1)) }}
                        </div>
                        <div class="min-w-0">
                            <p class="text-[10px] font-bold uppercase tracking-wider text-blue-500">Guru Piket Hari Ini</p>
                            <p class="text-sm font-bold text-blue-900 truncate">{{ $guruPiketHariIni->guru->nama_lengkap }}</p>
                        </div>
                    </div>

                    {{-- Kategori --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Kategori <span class="text-red-500">*</span></label>
                        <select name="kategori" required class="w-full h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                            <option value="">-- Pilih Kategori --</option>
                            <option value="sakit">Sakit</option>
                            <option value="izin">Izin</option>
                            <option value="keperluan_sekolah">Keperluan Sekolah</option>
                            <option value="lainnya">Lainnya</option>
                        </select>
                    </div>

                    {{-- Alasan --}}
                    <div>
                        <label class="block text-xs font-bold text-gray-700 mb-1.5">Alasan <span class="text-red-500">*</span></label>
                        <textarea name="alasan" required rows="3" placeholder="Jelaskan alasan pengajuan Anda..."
                                  class="w-full px-3.5 py-2.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all"></textarea>
                    </div>

                    {{-- Tujuan & Lokasi --}}
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Tujuan <span class="text-red-500">*</span></label>
                            <input type="text" name="tujuan" required placeholder="Contoh: Rumah Sakit"
                                   class="w-full h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Lokasi <span class="text-gray-400 font-normal">(Opsional)</span></label>
                            <input type="text" name="lokasi" placeholder="Contoh: Jl. Merdeka No. 1"
                                   class="w-full h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                        </div>
                    </div>

                    {{-- Jam --}}
                    <div class="grid grid-cols-2 gap-3">
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Jam Keluar <span class="text-red-500">*</span></label>
                            <select name="jam_keluar" required class="w-full h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                                <option value="">-- Pilih --</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                        <div>
                            <label class="block text-xs font-bold text-gray-700 mb-1.5">Jam Kembali <span class="text-red-500">*</span></label>
                            <select name="jam_kembali" required class="w-full h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-sm font-medium text-gray-800 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
                                <option value="">-- Pilih --</option>
                                @for($i = 1; $i <= 10; $i++)
                                    <option value="{{ $i }}">Jam ke-{{ $i }}</option>
                                @endfor
                            </select>
                        </div>
                    </div>

                    {{-- Aksi --}}
                    <div class="pt-1 flex flex-col sm:flex-row gap-2.5">
                        <button type="submit"
                                class="flex-1 inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 hover:from-blue-700 hover:to-blue-800 shadow-lg shadow-blue-500/30 active:scale-[0.98] transition-all">
                            <i class="fas fa-paper-plane mr-2"></i>Kirim Pengajuan
                        </button>
                        <a href="{{ route('siswa.pengajuan.index') }}"
                           class="inline-flex justify-center items-center px-5 py-3 rounded-xl text-sm font-bold text-gray-600 border border-gray-200 hover:bg-gray-50 transition-colors">
                            Batal
                        </a>
                    </div>
                </form>
            @endif
        </div>
    </div>
</div>
@endsection