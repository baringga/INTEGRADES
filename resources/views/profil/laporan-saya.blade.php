<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Riwayat Pengaduan Saya</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 mb-20">
    @include('components.navbar')

    <main class="max-w-4xl mx-auto py-10 px-4">
        <div class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Riwayat Pengaduan Saya</h1>
            <p class="text-gray-600 mt-1">Daftar semua laporan yang pernah Anda buat.</p>
        </div>

        <div class="space-y-4">
            @forelse($pengaduanSaya as $pengaduan)
                <div class="bg-white p-5 rounded-lg border border-gray-200">
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
                            <p class="text-sm text-gray-500 mt-1"><span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}</p>
                            <p class="text-sm text-gray-500"><span class="font-semibold">Kategori:</span> {{ $pengaduan->kategori }}</p>
                        </div>
                        <span class="text-xs text-gray-400">{{ $pengaduan->created_at->format('d M Y H:i') }}</span>
                    </div>
                    <p class="text-gray-600 mt-3 text-sm"><span class="font-semibold">Isi Pengaduan:</span> {{ $pengaduan->isi_pengaduan }}</p>
                    @if($pengaduan->foto)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="rounded-lg max-w-sm">
                        </div>
                    @endif
                    @if($pengaduan->tanggapan)
                        <div class="mt-4 p-4 bg-gray-50 rounded">
                            <span class="font-semibold text-primary">Tanggapan:</span>
                            <p class="text-gray-700 text-sm">{{ $pengaduan->tanggapan }}</p>
                        </div>
                    @endif
                </div>
            @empty
                <div class="text-center py-16 bg-white border rounded-lg">
                    <p class="text-gray-500">Anda belum pernah membuat laporan.</p>
                </div>
            @endforelse
        </div>
        <div class="mt-6">
            {{ $pengaduanSaya->links() }}
        </div>
    </main>
</body>
</html>
