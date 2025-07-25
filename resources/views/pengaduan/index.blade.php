@extends('layouts.app')

@section('content')
<main class="max-w-4xl mx-auto py-10 px-4">
    <div class="flex justify-between items-center mb-6">
        <h1 class="text-2xl font-bold text-[#74A740]">Daftar Laporan Masyarakat</h1>
        <a href="{{ route('dashboard') }}" class="bg-[#E6F4EA] border border-[#74A740] text-[#74A740] px-4 py-2 rounded-lg font-semibold hover:bg-[#d0f0d6] transition">
            Kembali ke Dashboard
        </a>
    </div>
    <div class="space-y-4">
        @forelse($pengaduan as $item)
            <div class="bg-white p-5 rounded-lg border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center w-full relative">
                {{-- Status di kanan atas --}}
                <div class="absolute top-4 right-4">
                    <span class="px-3 py-1 rounded-full text-xs font-semibold
                        @if($item->status == 'selesai')
                            bg-green-100 text-green-700 border border-green-400
                        @elseif($item->status == 'proses')
                            bg-yellow-100 text-yellow-700 border border-yellow-400
                        @else
                            bg-gray-100 text-gray-700 border border-gray-400
                        @endif
                    ">
                        {{ ucfirst($item->status ?? 'belum diproses') }}
                    </span>
                </div>
                <div class="w-full md:w-[75%]">
                    <h2 class="font-bold text-lg text-gray-800">{{ $item->judul }}</h2>
                    <p class="text-sm text-gray-500"><span class="font-semibold">Lokasi:</span> {{ $item->lokasi }}</p>
                    <p class="text-xs text-gray-400">{{ $item->created_at->format('d M Y H:i') }}</p>
                    <p class="text-gray-600 mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($item->isi_pengaduan, 80) }}</p>
                </div>
                <div class="mt-3 md:mt-0 md:ml-6 flex flex-col items-end w-full md:w-auto">
                    <a href="{{ route('pengaduan.show', $item->id) }}" class="bg-[#74A740] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a507834] transition w-full md:w-auto text-center">
                        Lihat Detail
                    </a>
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
