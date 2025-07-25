<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil {{ $user->namaPengguna ?? 'User' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
    <style>[x-cloak] { display: none !important; }</style>
</head>
<body class="mb-20" style="background-color: #FDFEFE;">
    @include('components.navbar')

    <main class="max-w-4xl mx-auto px-6 py-12" x-data="{ showEdit: false, tab: 'campaign_diikuti' }">
        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4" role="alert">{{ session('error') }}</div>
        @endif

        {{-- Informasi Profil --}}
        <div class="flex items-center gap-6 mb-12 justify-center">
            <div class="w-32 h-32 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                @if(empty($user->fotoProfil))
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.25a7.25 7.25 0 0115 0v.25a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.25z" />
                    </svg>
                @else
                    <img src="{{ asset('storage/' . $user->fotoProfil) }}" alt="Profile" class="w-full h-full object-cover" />
                @endif
            </div>
            <div class="flex flex-col items-start text-left">
                <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->namaPengguna }}</h1>
                <p class="mb-1">{{ $user->email }}</p>
                <p class="mb-4">{{ $user->nomorTelepon }}</p>
                <button
                    @click="showEdit = true"
                    type="button"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transform transition-transform duration-200 hover:scale-105"
                    style="background-color: #DDEDEE; border: 1px solid #DDEDEE; color: #333;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="black" stroke-width="3">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 9.75l-9.75 9.75H5.25v-1.5l9.75-9.75z" />
                    </svg>
                    Edit Profile
                </button>
            </div>
        </div>

        {{-- Badge Volunteer --}}
        <div class="flex gap-2 mb-4">
            @if($campaignsDiikuti->count() >= 5)
                <span class="inline-block bg-yellow-200 text-yellow-800 px-3 py-1 rounded-full text-xs font-semibold">Aktif Ikut Campaign</span>
            @endif
            @if($campaigns->count() >= 3)
                <span class="inline-block bg-blue-200 text-blue-800 px-3 py-1 rounded-full text-xs font-semibold">Pembuat Campaign</span>
            @endif
        </div>

        {{-- Statistik Profil --}}
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-xl p-4 text-center shadow">
                <div class="text-2xl font-bold text-[#74A740]">{{ $campaignsDiikuti->count() }}</div>
                <div class="text-gray-600 text-sm">Campaign Diikuti</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow">
                <div class="text-2xl font-bold text-[#74A740]">{{ $campaigns->count() }}</div>
                <div class="text-gray-600 text-sm">Campaign Dibuat</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow">
                <div class="text-2xl font-bold text-[#74A740]">{{ $pengaduanSaya->count() }}</div>
                <div class="text-gray-600 text-sm">Laporan</div>
            </div>
            <div class="bg-white rounded-xl p-4 text-center shadow">
                <div class="text-2xl font-bold text-[#74A740]">{{ $komentarList->count() }}</div>
                <div class="text-gray-600 text-sm">Komentar</div>
            </div>
        </div>

        {{-- Sistem Tab --}}
        <div>
            <div class="flex flex-wrap gap-x-8 sm:gap-x-16 mb-2 justify-center relative border-b">
                <button @click="tab = 'campaign_diikuti'" class="relative pb-3 font-medium" :class="tab === 'campaign_diikuti' ? 'text-gray-900 border-b-2 border-[#74A740]' : 'text-gray-500 hover:text-gray-900'">
                    Campaign Diikuti
                </button>
                <button @click="tab = 'campaign_dibuat'" class="relative pb-3 font-medium" :class="tab === 'campaign_dibuat' ? 'text-gray-900 border-b-2 border-[#74A740]' : 'text-gray-500 hover:text-gray-900'">
                    Campaign Dibuat
                </button>
                <button @click="tab = 'pengaduan_saya'" class="relative pb-3 font-medium" :class="tab === 'pengaduan_saya' ? 'text-gray-900 border-b-2 border-[#74A740]' : 'text-gray-500 hover:text-gray-900'">
                    Laporan Saya
                </button>
                <button @click="tab = 'komentar'" class="relative pb-3 font-medium" :class="tab === 'komentar' ? 'text-gray-900 border-b-2 border-[#74A740]' : 'text-gray-500 hover:text-gray-900'">
                    Komentar Saya
                </button>
            </div>

            {{-- Isi Tab --}}
            <div class="mt-4">
                {{-- Tab Campaign Diikuti --}}
                <div x-show="tab === 'campaign_diikuti'" x-cloak>
                    <h2 class="text-lg font-bold mb-4">Campaign yang Kamu Ikuti</h2>
                    @forelse($campaignsDiikuti as $campaign)
                        <div class="relative mb-6">
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        </div>
                    @empty
                        <div class="bg-white p-4 rounded-lg border text-center text-gray-500">
                            <p>Anda belum mengikuti campaign apapun.</p>
                        </div>
                    @endforelse
                </div>

                {{-- Tab Campaign Dibuat --}}
                <div x-show="tab === 'campaign_dibuat'">
                    <h2 class="text-lg font-bold mb-4">Campaign yang Kamu Buat</h2>
                    @forelse($campaigns as $campaign)
                        @php
                            $pendingCount = $campaign->partisipanCampaigns->where('status', 'pending')->count();
                        @endphp
                        <div class="relative mb-6"> {{-- Tambahkan margin bawah di sini --}}
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                            @if($pendingCount > 0)
                                <span class="absolute top-2 right-2 bg-yellow-500 text-white text-xs rounded-full px-2 py-1">
                                    {{ $pendingCount }} pendaftar baru
                                </span>
                            @endif
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada campaign yang kamu buat.</div>
                    @endforelse
                </div>

                <div x-show="tab === 'pengaduan_saya'">
                    <h2 class="text-lg font-bold mb-4">Laporan Saya</h2>
                    @forelse($pengaduanSaya as $pengaduan)
                        <div class="bg-white rounded-lg border overflow-hidden mb-6 shadow flex flex-col">
                            @if($pengaduan->foto)
                                <img src="{{ asset('storage/' . $pengaduan->foto) }}" alt="Foto Pengaduan" class="w-full h-48 object-cover">
                            @endif
                            <div class="flex-1 p-4 flex flex-col justify-between">
                                <div>
                                    <div class="flex items-center justify-between mb-2">
                                        <h3 class="font-bold text-lg break-words text-[#74A740] flex-1 min-w-0">{{ $pengaduan->judul }}</h3>
                                        <span class="px-3 py-1 rounded-full text-xs font-semibold shadow
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
                                    </div>
                                    <p class="text-sm text-gray-500 mb-1"><span class="font-semibold">Lokasi:</span> {{ $pengaduan->lokasi }}</p>
                                    <p class="text-xs text-gray-400 mb-2">{{ $pengaduan->created_at->format('d M Y H:i') }}</p>
                                    <p class="text-gray-600 break-words">{{ \Illuminate\Support\Str::limit($pengaduan->isi, 80) }}</p>
                                </div>
                                <div class="mt-4 flex justify-end">
                                    <a href="{{ route('pengaduan.show', $pengaduan->id) }}" class="bg-[#74A740] text-white px-4 py-2 rounded-lg font-semibold text-sm hover:bg-[#a507834] transition">
                                        Lihat Detail
                                    </a>
                                </div>
                            </div>
                        </div>
                    @empty
                        <div class="bg-white p-4 rounded-lg border text-center text-gray-500">
                            <p>Belum ada pengaduan yang kamu buat.</p>
                        </div>
                    @endforelse
                </div>
                <div x-show="tab === 'komentar'">
                    <h2 class="text-lg font-bold mb-4">Komentar Saya</h2>
                    @forelse($komentarList as $komentar)
                        <div class="bg-white p-4 rounded-lg border mb-2">
                            <div class="font-semibold">Pada campaign: <a href="{{ url('/campaign/'.$komentar->campaign_id) }}" class="text-[#74A740] hover:underline">{{ $komentar->nama_campaign }}</a></div>
                            <div class="text-sm text-gray-600">{{ $komentar->komentar }}</div>
                            <div class="text-xs text-gray-400 mt-1">{{ \Carbon\Carbon::parse($komentar->waktu)->diffForHumans() }}</div>
                        </div>
                    @empty
                        <div class="text-gray-500">Belum ada komentar yang kamu buat.</div>
                    @endforelse
                </div>
            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/10 backdrop-blur-sm">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative">
                <button @click="showEdit = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <h2 class="text-xl font-bold mb-4">Edit Profil</h2>
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="namaPengguna" value="{{ old('namaPengguna', $user->namaPengguna) }}" class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ old('email', $user->email) }}" class="w-full border rounded-lg px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Nomor Telepon</label>
                        <input type="text" name="nomorTelepon" value="{{ old('nomorTelepon', $user->nomorTelepon) }}" class="w-full border rounded-lg px-3 py-2">
                    </div>
                    {{-- Preview Foto Profil --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">Foto Profil</label>
                        <input type="file" name="fotoProfil" class="w-full border rounded-lg px-3 py-2" onchange="previewFoto(event)">
                        <img
                            id="preview-foto"
                            class="mt-2 w-20 h-20 rounded-full object-cover {{ empty($user->fotoProfil) ? 'hidden' : '' }}"
                            src="{{ !empty($user->fotoProfil) ? asset('storage/' . $user->fotoProfil) : '' }}"
                            alt="Preview Foto Profil"
                        />
                    </div>
                    <button type="submit" class="w-full bg-[#74A740] text-white rounded-lg py-2 font-semibold mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </main>

    <script>
    function previewFoto(event) {
        const file = event.target.files[0];
        const img = document.getElementById('preview-foto');
        if (!file) {
            // Jika tidak ada file baru, tampilkan foto lama (jika ada)
            @if(!empty($user->fotoProfil))
                img.src = "{{ asset('storage/' . $user->fotoProfil) }}";
                img.classList.remove('hidden');
            @else
                img.src = "";
                img.classList.add('hidden');
            @endif
            return;
        }
        img.src = URL.createObjectURL(file);
        img.classList.remove('hidden');
    }
    </script>
     <!-- Footer -->
    <footer class="py-8 px-4 bg-light border-t border-gray-200">
        <div class="max-w-7xl mx-auto text-center">
            <p class="text-gray text-sm">@2025 INTEGRADES. Hak cipta dilindungi.</p>
        </div>
    </footer>
</body>
</html>
