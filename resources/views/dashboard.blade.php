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
                placeholder="Cari data..."
                class="w-full md:w-1/2 px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#74A740]"
            />
            <select name="filter_menu" class="px-4 py-2 border rounded-lg focus:ring-2 focus:ring-[#74A740]">
                <option value="">Semua Menu</option>
                <option value="laporan_warga" {{ request('filter_menu') == 'laporan_warga' ? 'selected' : '' }}>Laporan Masyarakat</option>
                <option value="laporan_anda" {{ request('filter_menu') == 'laporan_anda' ? 'selected' : '' }}>Laporan Anda</option>
                <option value="campaign_diikuti" {{ request('filter_menu') == 'campaign_diikuti' ? 'selected' : '' }}>Campaign yang Anda Ikuti</option>
                <option value="campaign_dibuat" {{ request('filter_menu') == 'campaign_dibuat' ? 'selected' : '' }}>Campaign yang Anda Buat</option>
                <option value="rekomendasi" {{ request('filter_menu') == 'rekomendasi' ? 'selected' : '' }}>Rekomendasi Campaign</option>
            </select>
            <button type="submit" class="bg-[#74A740] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a507834] transition">
                Cari
            </button>
        </form>

        {{-- ====================================================== --}}
        {{-- BAGIAN 1: SEMUA LAPORAN WARGA (Untuk semua pengguna) --}}
        {{-- ====================================================== --}}
        <section class="mb-8">
            <div class="bg-[#eaf7e6] border-2 border-[#74A740] rounded-xl p-6 shadow">
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
                                    <h1 class="font-bold text-xl text-gray-1000">{{ $pengaduan->judul }}</h1>
                                    <p class="text-gray-600 mt-3 text-lg"><span class="font-semibold">Isi Pengaduan:</span> {{ $pengaduan->isi_pengaduan }}</p>
                                </div>
                                <span class="text-sm text-gray-400">{{ $pengaduan->created_at->format('d M Y H:i') }}</span>
                            </div>

                            @if(!empty($pengaduan->foto))
                                <div style="width:100%; text-align:center; margin: 1rem 0;">
                                    <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan"
                                         style="display:inline-block; max-width:500px; width:100%; height:auto; border-radius:16px; box-shadow:0 2px 8px #ccc;">
                                </div>
                            @endif

                            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 gap-3 mt-2 mb-2">
                                <div class="bg-gray-50 border rounded-lg p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}</p>
                                </div>
                                <div class="bg-gray-50 border rounded-sm p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Kelebihan Desa:</span> {{ $pengaduan->kelebihan_desa }}</p>
                                </div>
                                <div class="bg-gray-50 border rounded-sm p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Kekurangan Desa:</span> {{ $pengaduan->kekurangan_desa }}</p>
                                </div>
                                <div class="bg-gray-50 border rounded-sm p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Saran Aksi / Harapan:</span> {{ $pengaduan->saran_aksi }}</p>
                                </div>
                                <div class="bg-gray-50 border rounded-sm p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Pelapor:</span> {{ $pengaduan->akun->namaPengguna }}</p>
                                </div>
                                <div class="bg-gray-50 border rounded-sm p-3">
                                    <p class="text-sm text-gray-500"><span class="font-semibold">Kategori Laporan:</span> {{ $pengaduan->kategori_laporan }}</p>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="text-center py-10 bg-white border rounded-lg">
                            <p class="text-gray-500">Belum ada pengaduan yang dibuat.</p>
                        </div>
                    @endforelse
                </div>

                @if($filterMenu == 'laporan_warga' || !$filterMenu)
                    <div class="mt-6">
                        {{ $semuaPengaduan->links() }}
                    </div>
                @endif

                @if($filterMenu == 'laporan_anda')
                    <div class="mt-6">
                        {{ $laporanAnda->links() }}
                    </div>
                @endif

                @if($filterMenu == 'campaign_diikuti')
                    <div class="mt-6">
                        {{ $campaignDiikuti->links() }}
                    </div>
                @endif

                @if($filterMenu == 'campaign_dibuat')
                    <div class="mt-6">
                        {{ $campaignDibuat->links() }}
                    </div>
                @endif

                @if($filterMenu == 'rekomendasi')
                    <div class="mt-6">
                        {{ $rekomendasiCampaign->links() }}
                    </div>
                @endif
            </div>
        </section>

        {{-- ====================================================== --}}
        {{-- Blok Ini Hanya Tampil Untuk Volunteer Desa (ID 1) --}}
        {{-- ====================================================== --}}
        @if(Auth::user()->jenis_akun_id == 1)

            {{-- 2. Laporan Anda --}}
            <section class="mb-8">
                <div class="bg-[#eaf7e6] border-2 border-[#74A740] rounded-xl p-6 shadow">
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

            {{-- 3. Campaign yang Anda Ikuti --}}
            <section class="mb-8">
                <div class="bg-[#eaf7e6] border-2 border-[#74A740] rounded-xl p-6 shadow">
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

            {{-- 4. Campaign yang Anda Buat --}}
            <section class="mb-8">
                <div class="bg-[#eaf7e6] border-2 border-[#74A740] rounded-xl p-6 shadow">
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

            {{-- 5. Rekomendasi Campaign --}}
            <section class="mb-8">
                <div class="bg-[#eaf7e6] border-2 border-[#74A740] rounded-xl p-6 shadow">
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
