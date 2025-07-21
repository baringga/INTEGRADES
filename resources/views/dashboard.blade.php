<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard</title>
    @vite('resources/css/app.css')
</head>
<body class="mb-20 bg-gray-50">
    @include('components.navbar')

    <main class="max-w-7xl mx-auto py-10 px-4 space-y-16">

        {{-- ====================================================== --}}
        {{-- BAGIAN 1: SEMUA LAPORAN WARGA (Untuk semua pengguna) --}}
        {{-- ====================================================== --}}
        <section>
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
                @forelse($semuaPengaduan as $pengaduan)
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
                                <p class="text-sm text-gray-500 mt-1"><span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}</p>
                                <p class="text-sm text-gray-500"><span class="font-semibold">Pelapor:</span> {{ $pengaduan->akun->namaPengguna }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $pengaduan->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 mt-3 text-sm">{{ $pengaduan->isi_pengaduan }}</p>
                        @if($pengaduan->foto)
                        <div class="mt-4">
                            <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="rounded-lg max-w-sm">
                        </div>
                        @endif
                    </div>
                @empty
                    <div class="text-center py-10 bg-white border rounded-lg"><p class="text-gray-500">Belum ada pengaduan yang dibuat.</p></div>
                @endforelse
            </div>
            <div class="mt-6">
                {{ $semuaPengaduan->links() }}
            </div>
        </section>

        {{-- ====================================================== --}}
        {{-- Blok Ini Hanya Tampil Untuk Volunteer Desa (ID 1) --}}
        {{-- ====================================================== --}}
        @if(Auth::user()->jenis_akun_id == 1)

            {{-- 2. Laporan Anda --}}
            <section>
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Laporan Anda</h2>
                    <a href="{{ route('profil.laporan') }}" class="text-sm font-semibold text-[#810000] hover:underline">LIHAT SEMUA</a>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                    @forelse($laporanAnda as $laporan)
                        <div class="bg-white p-4 rounded-lg border hover:shadow-md transition">
                           <h3 class="font-bold text-md truncate">{{ $laporan->judul }}</h3>
                           <p class="text-xs text-gray-500">{{ $laporan->lokasi }}</p>
                           <p class="text-sm text-gray-600 mt-2 line-clamp-2 h-10">{{ $laporan->isi_pengaduan }}</p>
                           <span class="text-xs text-gray-400 mt-2 block">{{ $laporan->created_at->diffForHumans() }}</span>
                        </div>
                    @empty
                        <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Anda belum membuat laporan.</p></div>
                    @endforelse
                </div>
            </section>

            {{-- 3. Campaign yang Anda Ikuti --}}
            <section>
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Campaign yang Anda Ikuti</h2>
                    <a href="{{ route('campaign.followed') }}" class="text-sm font-semibold text-[#810000] hover:underline">LIHAT SEMUA</a>
                </div>
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                    @forelse($campaignDiikuti as $campaign)
                        @include('components.campaign-item', ['campaign' => $campaign])
                    @empty
                        <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Anda belum mengikuti campaign apapun.</p></div>
                    @endforelse
                </div>
            </section>

            {{-- 4. Campaign yang Anda Buat --}}
            <section>
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Campaign yang Anda Buat</h2>
                    <a href="{{ route('campaign.created') }}" class="text-sm font-semibold text-[#810000] hover:underline">LIHAT SEMUA</a>
                </div>
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                    @forelse($campaignDibuat as $campaign)
                        @include('components.campaign-item', ['campaign' => $campaign])
                    @empty
                        <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Anda belum membuat campaign.</p></div>
                    @endforelse
                </div>
            </section>

            {{-- 5. Rekomendasi Campaign --}}
            <section>
                <div class="flex justify-between items-center mb-4 border-b pb-2">
                    <h2 class="text-2xl font-bold text-gray-800">Rekomendasi Campaign</h2>
                    <a href="{{ route('campaign.recommendations') }}" class="text-sm font-semibold text-[#810000] hover:underline">LIHAT SEMUA</a>
                </div>
                 <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                    @forelse($rekomendasiCampaign as $campaign)
                        @include('components.campaign-item', ['campaign' => $campaign])
                    @empty
                        <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Saat ini tidak ada rekomendasi campaign.</p></div>
                    @endforelse
                </div>
            </section>

        @endif

    </main>
</body>
</html>
