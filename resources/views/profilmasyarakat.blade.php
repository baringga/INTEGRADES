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

    <main class="max-w-4xl mx-auto px-6 py-12" x-data="{ showEdit: false }">
        {{-- Notifikasi --}}
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">{{ session('success') }}</div>
        @endif
        @if($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4" role="alert">
                <ul class="list-disc list-inside">
                    @foreach($errors->all() as $err)
                        <li>{{ $err }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- Informasi Profil --}}
        <div class="flex items-center gap-6 mb-12 justify-center">
            <div class="w-30 h-30 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                {{-- Debug path --}}
                @php
                    echo '<!-- FOTO PROFIL: ' . $user->fotoProfil . ' -->';
                @endphp
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
                <a href="#" @click.prevent="showEdit = true"
                    class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transform transition-transform duration-200 hover:scale-105"
                    style="background-color: #DDEDEE; border: 1px solid #DDEDEE; color: #333;">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24" stroke="black" stroke-width="3"><path stroke-linecap="round" stroke-linejoin="round" d="M15.232 5.232l3.536 3.536M16.5 9.75l-9.75 9.75H5.25v-1.5l9.75-9.75z" /></svg>
                    Edit Profile
                </a>
            </div>
        </div>

        {{-- Riwayat Pengaduan --}}
        <div>
            <h2 class="text-xl font-bold text-center mb-4">Riwayat Pengaduan Saya</h2>
            <div class="space-y-4">
                @forelse($pengaduanSaya as $pengaduan)
                    <div class="bg-white p-4 rounded-lg border border-gray-200">
                        <div class="flex justify-between items-start">
                            <div>
                                <h3 class="font-bold text-md text-gray-800">{{ $pengaduan->judul }}</h3>
                                <p class="text-sm text-gray-500 mt-1">Lokasi: {{ $pengaduan->lokasi }}</p>
                            </div>
                            <span class="text-xs text-gray-400">{{ $pengaduan->created_at->diffForHumans() }}</span>
                        </div>
                        <p class="text-gray-600 mt-2 text-sm">{{ $pengaduan->isi_pengaduan }}</p>
                    </div>
                @empty
                    <div class="bg-white p-4 rounded-lg border text-center text-gray-500">
                        <p>Anda belum pernah membuat pengaduan.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center bg-black/10 backdrop-blur-sm">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative">
                <button @click="showEdit = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama</label>
                        <input type="text" name="namaPengguna" value="{{ $user->namaPengguna }}" class="w-full rounded-lg border px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}" class="w-full rounded-lg border px-3 py-2" required>
                    </div>
                     <div>
                        <label class="block text-sm font-medium mb-1">Nomor Telepon</label>
                        <input type="text" name="nomorTelepon" value="{{ $user->nomorTelepon }}" class="w-full rounded-lg border px-3 py-2" required>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Foto Profil</label>
                         <input type="file" name="fotoProfil" class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#DDEDEE] file:text-[#74A740] hover:file:bg-[#c9e0e1]">
                    </div>
                    <button type="submit" class="w-full bg-[#74A740] text-white rounded-lg py-2 font-semibold mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </main>
</body>
</html>
