<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Profil {{ $user->namaPengguna ?? 'User' }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
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
            {{-- ... (kode informasi profil tetap sama) ... --}}
        </div>

        {{-- Sistem Tab --}}
        <div>
            <div class="flex flex-wrap gap-x-8 sm:gap-x-16 mb-2 justify-center relative border-b">
                <button @click="tab = 'campaign_diikuti'" class="relative pb-3 font-medium" :class="tab === 'campaign_diikuti' ? 'text-gray-900 border-b-2 border-[#810000]' : 'text-gray-500 hover:text-gray-900'">
                    Campaign Diikuti
                </button>
                <button @click="tab = 'campaign_dibuat'" class="relative pb-3 font-medium" :class="tab === 'campaign_dibuat' ? 'text-gray-900 border-b-2 border-[#810000]' : 'text-gray-500 hover:text-gray-900'">
                    Campaign Dibuat
                </button>
                <button @click="tab = 'pengaduan_saya'" class="relative pb-3 font-medium" :class="tab === 'pengaduan_saya' ? 'text-gray-900 border-b-2 border-[#810000]' : 'text-gray-500 hover:text-gray-900'">
                    Pengaduan Saya
                </button>
                <button @click="tab = 'komentar'" class="relative pb-3 font-medium" :class="tab === 'komentar' ? 'text-gray-900 border-b-2 border-[#810000]' : 'text-gray-500 hover:text-gray-900'">
                    Komentar
                </button>
            </div>

            {{-- Isi Tab --}}
            <div class="mt-4">
                <div x-show="tab === 'campaign_diikuti'">
                    {{-- Diisi dengan daftar campaign yang diikuti user --}}
                </div>
                <div x-show="tab === 'campaign_dibuat'">
                    {{-- Diisi dengan daftar campaign yang dibuat user --}}
                </div>
                <div x-show="tab === 'pengaduan_saya'">
                    {{-- Diisi dengan daftar pengaduan yang dibuat user --}}
                </div>
                <div x-show="tab === 'komentar'">
                    {{-- Kode tab komentar yang lama akan dikembalikan ke sini --}}
                    {{-- @include('components.komentarprofil-section') --}}
                </div>
            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/10 backdrop-blur-sm">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative">
                <button @click="showEdit = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    {{-- ... (form input nama, email, telepon, foto) ... --}}
                    <div>
                        <label class="block text-sm font-medium mb-1">URL Portofolio</label>
                        <input type="url" name="portofolio" value="{{ $user->akunKomunitas->portofolio ?? '' }}"
                            class="w-full rounded-lg border px-3 py-2" placeholder="https://linkedin.com/in/username">
                        <p class="text-xs text-gray-500 mt-1">Wajib diisi untuk membuat campaign. Contoh: URL Google Drive, LinkedIn, atau Blog.</p>
                    </div>
                    <button type="submit" class="w-full bg-[#810000] text-white rounded-lg py-2 font-semibold mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
