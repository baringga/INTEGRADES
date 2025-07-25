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
        {{-- FORM PENCARIAN --}}
        {{-- ====================================================== --}}
        <form method="GET" action="{{ route('dashboard') }}" class="mb-8 flex flex-col md:flex-row gap-3 items-center">
            <input
                type="text"
                name="q"
                value="{{ request('q') }}"
                placeholder="Tulis kata kunci untuk mencari..."
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#74A740] text-[#74A740] bg-gray-100 h-12"
            />
            <select name="filter_menu" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#74A740] text-[#74A740] h-12 bg-gray-100 font-bold text-center">
                <option value="" class="text-[#74A740] text-center">Semua Menu</option>
                <option value="laporan_warga" class="text-[#74A740] text-center" {{ request('filter_menu') == 'laporan_warga' ? 'selected' : '' }}>Laporan Masyarakat</option>
                <option value="laporan_anda" class="text-[#74A740] text-center" {{ request('filter_menu') == 'laporan_anda' ? 'selected' : '' }}>Laporan Anda</option>
                <option value="campaign_diikuti" class="text-[#74A740] text-center" {{ request('filter_menu') == 'campaign_diikuti' ? 'selected' : '' }}>Campaign yang Anda Ikuti</option>
                <option value="campaign_dibuat" class="text-[#74A740] text-center" {{ request('filter_menu') == 'campaign_dibuat' ? 'selected' : '' }}>Campaign yang Anda Buat</option>
                <option value="rekomendasi" class="text-[#74A740] text-center" {{ request('filter_menu') == 'rekomendasi' ? 'selected' : '' }}>Rekomendasi Campaign</option>
            </select>
            <button type="submit" class="bg-[#74A740] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a507834] transition">
                Cari
            </button>
        </form>

        {{-- Rekomendasi Campaign, Campaign yang Anda Buat, Campaign yang Anda Ikuti hanya untuk user 1 --}}
        @if(Auth::user()->jenis_akun_id == 1)
            {{-- 1. Rekomendasi Campaign --}}
            <section class="mb-8">
                <div class="bg-[#00000] border-2 border-[#74A740] rounded-xl p-6 shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-[#74A740]">Rekomendasi Campaign</h1>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                        @forelse($rekomendasiCampaign as $campaign)
                            @include('components.campaign-item', ['campaign' => $campaign])
                        @empty
                            <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Saat ini tidak ada rekomendasi campaign.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- 2. Campaign yang Anda Buat --}}
            <section class="mb-8">
                <div class="bg-[#00000] border-2 border-[#74A740] rounded-xl p-6 shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-[#74A740]">Campaign yang Anda Buat</h1>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                        @forelse($campaignDibuat as $campaign)
                            @include('components.campaign-item', ['campaign' => $campaign])
                        @empty
                            <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Anda belum membuat campaign.</p></div>
                        @endforelse
                    </div>
                </div>
            </section>

            {{-- 3. Campaign yang Anda Ikuti --}}
            <section class="mb-8">
                <div class="bg-[#00000] border-2 border-[#74A740] rounded-xl p-6 shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-[#74A740]">Campaign yang Anda Ikuti</h1>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                        @forelse($campaignDiikuti as $campaign)
                            @include('components.campaign-item', ['campaign' => $campaign])
                        @empty
                            <div class="col-span-3 text-center py-5 bg-white border rounded-lg"><p class="text-gray-500">Anda belum mengikuti campaign apapun.</p></div>
                        @endforelse
                    </div>
                    <div class="mt-6">
                        {{ $campaignDiikuti->links() }}
                    </div>
                </div>
            </section>
        @endif

        {{-- Laporan Masyarakat untuk semua user --}}
        <section class="mb-8">
            <div class="bg-[#00000] border-2 border-[#74A740] rounded-xl p-6 shadow">
                <div class="flex justify-between items-center mb-6">
                    <h1 class="text-3xl font-bold text-[#74A740]">Laporan Masyarakat</h1>
                    @auth
                    <div>
                        <a href="{{ route('pengaduan.create') }}" class="bg-[#74A740] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a507834] transition">
                            + Buat Laporan
                        </a>
                    </div>
                    @endauth
                </div>
                @if(session('success'))
                    <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">{{ session('success') }}</div>
                @endif
                <div class="space-y-4">
                    @foreach($semuaPengaduan->take(4) as $pengaduan)
                        <div class="bg-white p-5 rounded-lg border border-gray-200 flex flex-col md:flex-row justify-between items-start md:items-center">
                            <div>
                                <h2 class="font-bold text-lg text-[#74A740]">{{ $pengaduan->judul }}</h2>
                                <p class="text-sm text-gray-500"><span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}</p>
                                <p class="text-xs text-gray-400">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                                <p class="text-gray-600 mt-2 line-clamp-2">{{ \Illuminate\Support\Str::limit($pengaduan->isi_pengaduan, 80) }}</p>
                            </div>
                            <div class="mt-3 md:mt-0 md:ml-6 flex flex-col items-end">
                                <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="bg-[#74A740] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a507834] transition">
                                    Lihat Detail
                                </a>
                            </div>
                        </div>
                    @endforeach
                    @if($semuaPengaduan->isEmpty())
                        <div class="text-center py-10 bg-white border rounded-lg">
                            <p class="text-gray-500">Belum ada laporan masyarakat.</p>
                        </div>
                    @endif
                </div>
                <div class="mt-6 flex justify-end">
                    <a href="{{ route('pengaduan.index') }}" class="bg-[#E6F4EA] border border-[#74A740] text-[#74A740] px-6 py-2 rounded-lg font-semibold hover:bg-[#d0f0d6] transition">
                        Lihat Semua
                    </a>
                </div>
            </div>
        </section>

        {{-- Laporan Anda untuk user 1 dan 2 --}}
        @if(Auth::user()->jenis_akun_id == 1 || Auth::user()->jenis_akun_id == 2)
            <section class="mb-8">
                <div class="bg-[#00000] border-2 border-[#74A740] rounded-xl p-6 shadow">
                    <div class="flex justify-between items-center mb-6">
                        <h1 class="text-3xl font-bold text-[#74A740]">Laporan Anda</h1>
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
                </div>
            </section>
        @endif
    </main>

 <!-- Footer -->
    <footer class="py-8 px-4 bg-light border-t border-gray-200">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray text-sm">@2025 INTEGRADES. Hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
