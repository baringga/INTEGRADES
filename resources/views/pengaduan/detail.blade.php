{{-- filepath:  sources/views/pengaduan/detail.blade.php --}}
@extends('layouts.app')

@section('content')
<main class="max-w-3xl mx-auto py-10 px-4">
    <div class="bg-green-50 rounded-xl shadow-md p-8 border border-[#74A740]">
        <h1 class="text-2xl font-bold text-[#74A740] break-words">{{ $pengaduan->judul }}</h1>
        <p class="mt-4 text-gray-700 break-words">{{ $pengaduan->isi_pengaduan }}</p>
        <span class="mb-4 inline-block px-3 py-1 rounded-full text-xs font-semibold
            @if($pengaduan->status == 'selesai')
                bg-green-100 text-green-700 border border-green-400
            @elseif($pengaduan->status == 'proses' || $pengaduan->status == 'diproses')
                bg-yellow-100 text-yellow-700 border border-yellow-400
            @elseif($pengaduan->status == 'ditolak')
                bg-red-100 text-red-700 border border-red-400
            @else
                bg-gray-100 text-gray-700 border border-gray-400
            @endif
        ">
            {{ ucfirst($pengaduan->status ?? 'belum diproses') }}
        </span>
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
            <div class="text-gray-700 break-words mt-1">{{ $pengaduan->lokasi }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Waktu Kejadian:</strong>
            <div class="text-gray-700 break-words mt-1">{{ \Carbon\Carbon::parse($pengaduan->waktu)->translatedFormat('d F Y H:i') }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Kelebihan Desa:</strong>
            <div class="text-gray-700 break-words mt-1">{{ $pengaduan->kelebihan_desa }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Kekurangan Desa:</strong>
            <div class="text-gray-700 break-words mt-1">{{ $pengaduan->kekurangan_desa }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Isi Laporan:</strong>
            <div class="text-gray-700 break-words mt-1">{{ $pengaduan->isi_pengaduan }}</div>
        </div>
        <div class="mb-4">
            <strong class="text-[#6B3F22]">Saran Aksi / Harapan:</strong>
            <div class="text-gray-700 break-words mt-1">{{ $pengaduan->saran_aksi }}</div>
        </div>
        @if($pengaduan->foto)
            <div class="mb-4">
                <strong class="text-[#6B3F22]">Foto Laporan:</strong>
                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Laporan" class="w-full max-w-ms rounded-lg mt-2">
            </div>
        @endif
        <div class="mt-8 flex gap-4 justify-end">
            <a href="{{ route('pengaduan.index') }}" class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg font-semibold hover:bg-red-200 transition">
                Kembali ke Daftar Laporan
            </a>
        </div>
    </div>
</main>
@endsection
