<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Beranda Pengaduan Desa</title>
    @vite('resources/css/app.css')
</head>
<body class="mb-20 bg-gray-50">
    @include('components.navbar')

    <main class="max-w-4xl mx-auto py-10 px-4">
        <div class="flex justify-between items-center mb-6">
            <h1 class="text-3xl font-bold text-gray-800">Laporan Warga</h1>
            @auth
            <div>
                <a href="{{ route('pengaduan.create') }}" class="bg-[#810000] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a30000] transition">
                    + Buat Pengaduan
                </a>
            </div>
            @endauth
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">{{ session('success') }}</div>
        @endif

        <div class="space-y-4">
            @forelse($pengaduanList as $pengaduan)
                <div class="bg-white p-5 rounded-lg border border-gray-200 transition hover:shadow-md">
                    <div class="flex justify-between items-start">
                        <div>
                            @if($pengaduan->status == 'selesai')
                                <p class="text-xs text-white bg-green-500 font-bold inline-block px-2 py-0.5 rounded-full mb-2">Selesai</p>
                            @elseif($pengaduan->status == 'diproses')
                                <p class="text-xs text-white bg-blue-500 font-bold inline-block px-2 py-0.5 rounded-full mb-2">Diproses</p>
                            @else
                                <p class="text-xs text-white bg-yellow-500 font-bold inline-block px-2 py-0.5 rounded-full mb-2">Dilaporkan</p>
                            @endif
                            <h2 class="font-bold text-lg text-gray-800">{{ $pengaduan->judul }}</h2>
                            <p class="text-sm text-gray-500 mt-1">
                                <span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}
                            </p>
                            <p class="text-sm text-gray-500">
                                <span class="font-semibold">Pelapor:</span> {{ $pengaduan->akun->namaPengguna }}
                            </p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $pengaduan->created_at->diffForHumans() }}</span>
                    </div>
                    <p class="text-gray-600 mt-3 text-sm">
                        {{ $pengaduan->isi_pengaduan }}
                    </p>
                    @if($pengaduan->foto)
                    <div class="mt-4">
                        <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="rounded-lg max-w-sm">
                    </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16">
                    <p class="text-gray-500">Belum ada pengaduan yang dibuat.</p>
                </div>
            @endforelse
        </div>
    </main>
</body>
</html>
