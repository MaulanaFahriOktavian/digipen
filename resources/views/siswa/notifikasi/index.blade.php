@extends('siswa.layouts.app')

@section('title', 'Notifikasi')
@section('page-title', 'Notifikasi')

@section('content')

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">

    {{-- Header --}}
    <div class="p-4 sm:p-5 border-b border-gray-100 flex justify-between items-center gap-3">
        <div>
            <h3 class="text-sm font-bold text-gray-900"><i class="fas fa-bell mr-1.5 text-blue-600"></i>Notifikasi</h3>
            <p class="text-[11px] text-gray-500 mt-0.5">Informasi terbaru pengajuan dispensasi Anda.</p>
        </div>
        @if($notifikasi->where('is_read', false)->count() > 0)
            <form method="POST" action="{{ route('siswa.notifikasi.readAll') }}">
                @csrf
                <button type="submit" class="inline-flex items-center px-3 py-2 rounded-xl text-[11px] font-bold text-blue-600 bg-blue-50 border border-blue-100 active:bg-blue-100 transition-colors flex-shrink-0">
                    <i class="fas fa-check-double mr-1.5"></i>Semua Dibaca
                </button>
            </form>
        @endif
    </div>

    {{-- List --}}
    <div class="divide-y divide-gray-100">
        @forelse($notifikasi as $notif)
            <div class="p-4 flex justify-between items-start gap-3 transition-colors
                        {{ !$notif->is_read ? 'bg-blue-50/60 border-l-4 border-l-blue-600' : 'bg-white active:bg-gray-50' }}">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 flex-wrap">
                        <p class="font-bold text-gray-800 text-sm">{{ $notif->title }}</p>
                        @if(!$notif->is_read)
                            <span class="px-2 py-0.5 rounded-full bg-blue-600 text-white text-[9px] font-bold">BARU</span>
                        @endif
                    </div>
                    <p class="text-xs text-gray-600 mt-1 leading-relaxed">{{ $notif->message }}</p>
                    <p class="text-[10px] text-gray-400 mt-1.5"><i class="far fa-clock mr-1"></i>{{ $notif->created_at->diffForHumans() }}</p>
                </div>
                @if(!$notif->is_read)
                    <form method="POST" action="{{ route('siswa.notifikasi.read', $notif) }}">
                        @csrf
                        <button type="submit" class="w-9 h-9 rounded-xl bg-white border border-blue-200 text-blue-600 active:bg-blue-600 active:text-white transition-colors flex-shrink-0" title="Tandai Dibaca">
                            <i class="fas fa-envelope-open-text text-xs"></i>
                        </button>
                    </form>
                @else
                    <i class="fas fa-envelope-open text-gray-300 mt-1 flex-shrink-0"></i>
                @endif
            </div>
        @empty
            <div class="p-10 text-center">
                <div class="w-16 h-16 mx-auto rounded-2xl bg-blue-50 text-blue-300 flex items-center justify-center text-2xl mb-3"><i class="fas fa-bell-slash"></i></div>
                <p class="text-gray-500 font-semibold text-sm">Tidak ada notifikasi</p>
            </div>
        @endforelse
    </div>

    @if($notifikasi->hasPages())
        <div class="p-4 border-t border-gray-100 bg-gray-50/50">{{ $notifikasi->links() }}</div>
    @endif
</div>
@endsection