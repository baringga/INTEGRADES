{{-- filepath: resources/views/pengaduan/detail.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="max-w-3xl mx-auto py-10 px-4">
    <div class="bg-white rounded-xl shadow-md p-8">
        <h1 class="text-2xl font-bold text-[#6B3F22] mb-2">{{ $pengaduan->judul }}</h1>
        <div class="text-sm text-gray-500 mb-4">
            Dilaporkan oleh: <span class="font-semibold">{{ $pengaduan->akun->namaPengguna ?? 'Anonim' }}</span>
            <span class="mx-2">|</span>
            {{ \Carbon\Carbon::parse($pengaduan->created_at)->translatedFormat('d F Y H:i') }}
        </div>
        <div class="mb-4">
            <span class="inline-block bg-[#74A740] text-white px-3 py-1 rounded-full text-xs font-semibold">
                {{ $pengaduan->kategori_laporan ?? $pengaduan->kategori_laporan_custom ?? 'Tanpa Kategori' }}
            </span>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Lokasi Desa:</strong>
            <div class="text-gray-700">{{ $pengaduan->lokasi }}</div>
            @if($pengaduan->latitude && $pengaduan->longitude)
                <div id="map" style="height: 200px; border-radius: 0.75rem; margin-top: 0.5rem;"></div>
                <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
                <script>
                    document.addEventListener('DOMContentLoaded', function() {
                        var map = L.map('map').setView([{{ $pengaduan->latitude }}, {{ $pengaduan->longitude }}], 15);
                        L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
                        L.marker([{{ $pengaduan->latitude }}, {{ $pengaduan->longitude }}]).addTo(map);
                    });
                </script>
            @endif
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Waktu Kejadian:</strong>
            <span class="text-gray-700">{{ \Carbon\Carbon::parse($pengaduan->waktu)->translatedFormat('d F Y H:i') }}</span>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Kelebihan Desa:</strong>
            <div class="text-gray-700">{{ $pengaduan->kelebihan_desa }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Kekurangan Desa:</strong>
            <div class="text-gray-700">{{ $pengaduan->kekurangan_desa }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Isi Laporan:</strong>
            <div class="text-gray-700">{{ $pengaduan->isi_pengaduan }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Saran Aksi / Harapan:</strong>
            <div class="text-gray-700">{{ $pengaduan->saran_aksi }}</div>
        </div>
        @if($pengaduan->foto)
            <div class="mb-4">
                <strong class="text-[#6B3F22]">Foto Laporan:</strong>
                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Laporan" class="w-full max-w-xs rounded-lg mt-2">
            </div>
        @endif
        <div class="mt-8 flex gap-4">
            <a href="{{ route('pengaduan.index') }}" class="bg-gray-200 text-[#6B3F22] px-4 py-2 rounded-lg font-semibold hover:bg-gray-300">Kembali ke Daftar Laporan</a>
        </div>
    </div>
</main>
@endsection
