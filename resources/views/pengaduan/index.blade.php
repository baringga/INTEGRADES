@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-4xl font-bold text-[#74A740]">Daftar Laporan Masyarakat</h1>
        <a href="{{ route('dashboard') }}" class="bg-red-100 border border-red-400 text-red-700 px-4 py-2 rounded-lg font-semibold hover:bg-red-200 transition">
            Kembali ke Dashboard
        </a>
    </div>
    <div class="space-y-4">
        @forelse($pengaduan as $item)
            <div class="bg-white p-0 rounded-lg border border-gray-200 flex flex-col w-full relative overflow-hidden">
                <div class="relative">
                    @if($item->foto)
                        <img src="{{ asset('storage/' . $item->foto) }}" alt="Foto Pengaduan" class="w-full h-48 object-cover rounded-t-lg">
                    @endif
                    {{-- Status di kanan atas menindih gambar --}}
                    <div class="absolute top-4 right-4 z-10">
                        <span class="px-3 py-1 rounded-full text-xs font-semibold shadow
                            @if($item->status == 'selesai')
                                bg-green-100 text-green-700 border border-green-400
                            @elseif($item->status == 'proses' || $item->status == 'diproses')
                                bg-yellow-100 text-yellow-700 border border-yellow-400
                            @elseif($item->status == 'ditolak')
                                bg-red-100 text-red-700 border border-red-400
                            @else
                                bg-gray-100 text-gray-700 border border-gray-400
                            @endif
                        ">
                            {{ ucfirst($item->status ?? 'belum diproses') }}
                        </span>
                    </div>
                </div>
                <div class="p-5 flex flex-col md:flex-row justify-between items-start md:items-center w-full relative">
                    <div class="w-full md:w-[75%] flex flex-col gap-2">
                        <div class="flex-1">
                            <h2 class="font-bold text-lg text-gray-800 break-words whitespace-normal text-left">
                                {{ $item->judul }}
                            </h2>
                            <p class="text-sm text-gray-500 text-left"><span class="font-semibold">Lokasi:</span> {{ $item->lokasi }}</p>
                            <p class="text-xs text-gray-400 text-left">{{ $item->created_at->format('d M Y H:i') }}</p>
                            <p class="text-gray-600 mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($item->isi_pengaduan, 80) }}</p>
                        </div>
                    </div>
                    <div class="mt-3 md:mt-0 md:ml-6 flex flex-col items-end w-full md:w-auto">
                        <a href="{{ route('pengaduan.show', $item->id) }}" class="bg-[#74A740] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a507834] transition w-full md:w-auto text-center">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            </div>
        @empty
            <div class="text-center py-10 bg-white border rounded-lg">
                <p class="text-gray-500">Belum ada laporan masyarakat.</p>
            </div>
        @endforelse
    </div>
    <div class="mt-6">
        {{ $pengaduan->links() }}
    </div>
</main>
@endsection
