@extends('satpam.layouts.app')

@section('title', 'Scan QR Code')
@section('page-title', 'Scan QR Code')

@section('content')

<div class="max-w-md mx-auto space-y-4">

    {{-- Instruksi --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4 flex items-center space-x-3">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-blue-600 to-sky-500 text-white flex items-center justify-center shadow-md shadow-blue-500/30 flex-shrink-0">
            <i class="fas fa-qrcode"></i>
        </div>
        <div>
            <h3 class="text-sm font-bold text-gray-900">Scan QR Dispensasi</h3>
            <p class="text-[11px] text-gray-500">Arahkan kamera ke QR Code pada layar HP siswa.</p>
        </div>
    </div>

    {{-- Kamera --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="relative bg-gray-900">
            <div id="reader" class="w-full"></div>
        </div>
        <div class="p-3.5 flex items-center justify-between">
            <span id="scanStatus" class="inline-flex items-center text-[11px] font-bold text-emerald-600">
                <span class="w-2 h-2 rounded-full bg-emerald-400 mr-1.5 animate-pulse"></span> Kamera aktif — menunggu scan
            </span>
            <button onclick="restartScanner()" class="inline-flex items-center px-3 py-2 rounded-xl text-[11px] font-bold text-blue-600 bg-blue-50 border border-blue-100 active:bg-blue-100 transition-colors">
                <i class="fas fa-redo mr-1.5"></i>Scan Ulang
            </button>
        </div>
    </div>

    {{-- Hasil Scan --}}
    <div id="scanResult" class="hidden rounded-2xl border-2 p-4"></div>

    {{-- Verifikasi Manual (cadangan jika kamera bermasalah) --}}
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-4">
        <p class="text-[11px] font-bold uppercase tracking-wider text-gray-400 mb-2">Verifikasi Manual</p>
        <form onsubmit="manualVerify(event)" class="flex gap-2">
            <input type="text" id="manualCode" required placeholder="Tempel / ketik kode QR siswa..."
                   class="flex-1 h-11 px-3.5 rounded-xl border-2 border-gray-200 bg-white text-xs font-mono text-gray-800 placeholder-gray-400 focus:outline-none focus:border-blue-600 focus:ring-4 focus:ring-blue-100 transition-all">
            <button type="submit" class="px-4 h-11 rounded-xl text-xs font-bold text-white bg-gradient-to-r from-blue-600 to-blue-700 shadow-md shadow-blue-500/20 active:scale-[0.98] transition-all">
                <i class="fas fa-search mr-1"></i>Cek
            </button>
        </form>
    </div>
</div>

<script src="https://unpkg.com/html5-qrcode" type="text/javascript"></script>

@push('scripts')
<script>
let html5QrCode;
let isScanning = false;

function setStatus(text, ok = true) {
    const el = document.getElementById('scanStatus');
    el.innerHTML = `<span class="w-2 h-2 rounded-full ${ok ? 'bg-emerald-400 animate-pulse' : 'bg-amber-400'} mr-1.5"></span> ${text}`;
    el.className = `inline-flex items-center text-[11px] font-bold ${ok ? 'text-emerald-600' : 'text-amber-600'}`;
}

function verify(code) {
    setStatus('Memverifikasi data...', false);

    fetch('{{ route("satpam.scan.verify") }}', {
        method: 'POST',
        headers: { 'Content-Type': 'application/json', 'X-CSRF-TOKEN': '{{ csrf_token() }}' },
        body: JSON.stringify({ qr_data: code })
    })
    .then(r => r.json())
    .then(data => {
        const result = document.getElementById('scanResult');
        result.classList.remove('hidden');

        if (data.success) {
            if (navigator.vibrate) navigator.vibrate([120, 60, 120]); // getar di HP
            result.className = 'rounded-2xl border-2 p-4 bg-emerald-50 border-emerald-300';
            result.innerHTML = `
                <div class="flex items-center space-x-3 mb-3">
                    <div class="w-11 h-11 rounded-full bg-emerald-500 text-white flex items-center justify-center text-lg shadow-lg shadow-emerald-500/40"><i class="fas fa-check"></i></div>
                    <div>
                        <p class="font-black text-emerald-800 text-base leading-tight">${data.message}</p>
                        <p class="text-[11px] text-emerald-600 font-semibold">QR Code valid & terverifikasi</p>
                    </div>
                </div>
                <div class="bg-white rounded-xl border border-emerald-200 p-3 text-xs space-y-1">
                    <p><span class="text-gray-500">Nama:</span> <strong class="text-gray-800">${data.data.siswa.nama_lengkap}</strong></p>
                    <p><span class="text-gray-500">Kelas:</span> <strong class="text-gray-800">${data.data.siswa.kelas.nama_kelas}</strong></p>
                    <p><span class="text-gray-500">No. Surat:</span> <strong class="font-mono text-gray-800">${data.data.nomor_surat}</strong></p>
                    <p><span class="text-gray-500">Jam Kembali:</span> <strong class="text-gray-800">${data.data.jam_kembali}</strong></p>
                </div>`;
        } else {
            if (navigator.vibrate) navigator.vibrate(300);
            result.className = 'rounded-2xl border-2 p-4 bg-red-50 border-red-300';
            result.innerHTML = `
                <div class="flex items-center space-x-3">
                    <div class="w-11 h-11 rounded-full bg-red-500 text-white flex items-center justify-center text-lg shadow-lg shadow-red-500/40"><i class="fas fa-xmark"></i></div>
                    <div>
                        <p class="font-black text-red-800 text-base leading-tight">GAGAL</p>
                        <p class="text-xs text-red-700 font-semibold">${data.message}</p>
                    </div>
                </div>`;
        }
    })
    .catch(() => {
        const result = document.getElementById('scanResult');
        result.classList.remove('hidden');
        result.className = 'rounded-2xl border-2 p-4 bg-red-50 border-red-300';
        result.innerHTML = '<p class="text-red-800 font-bold text-sm"><i class="fas fa-triangle-exclamation mr-1"></i>Terjadi kesalahan koneksi.</p>';
    })
    .finally(() => {
        setTimeout(() => {
            document.getElementById('scanResult').classList.add('hidden');
            isScanning = true;
            html5QrCode.resume();
            setStatus('Kamera aktif — menunggu scan');
        }, 4000);
    });
}

function onScanSuccess(decodedText) {
    if (!isScanning) return;
    isScanning = false;
    html5QrCode.pause();
    verify(decodedText);
}

function restartScanner() {
    document.getElementById('scanResult').classList.add('hidden');
    isScanning = true;
    html5QrCode.resume();
    setStatus('Kamera aktif — menunggu scan');
}

function manualVerify(e) {
    e.preventDefault();
    const code = document.getElementById('manualCode').value.trim();
    if (!code) return;
    isScanning = false;
    html5QrCode.pause();
    verify(code);
    document.getElementById('manualCode').value = '';
}

html5QrCode = new Html5Qrcode("reader");
html5QrCode.start(
    { facingMode: "environment" },
    { fps: 10, qrbox: { width: 220, height: 220 } },
    onScanSuccess
)
.then(() => { isScanning = true; })
.catch(() => setStatus('Kamera tidak tersedia — gunakan verifikasi manual', false));
</script>
@endpush
@endsection