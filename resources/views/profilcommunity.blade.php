<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profil {{ isset($user) && $user ? $user->namaPengguna : (isset($akun) && $akun ? $akun->namaPengguna : 'User') }}</title>
    @vite('resources/css/app.css')
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>

<body class="mb-20 min-h-screen" style="background-color: #FDFEFE;">
    @include('components.navbar')

    {{-- Profile Section --}}
    <main class="max-w-4xl mx-auto px-6 py-12" x-data="{ showEdit: false, tab: 'all' }">
        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">
                {{ session('success') }}
            </div>
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
        <div class="flex items-center gap-6 mb-12 justify-center">
            @guest
                <div class="w-30 h-30 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                    <!-- Heroicon: User -->
                    <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                        viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round"
                            d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.25a7.25 7.25 0 0115 0v.25a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.25z" />
                    </svg>
                </div>
                <div class="flex flex-col items-start text-left">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">Guest</h1>
                    <p class="mb-4">-</p>
                    <a href="{{ route('login') }}"
                        class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transform transition-transform duration-200 hover:scale-105"
                        style="background-color: #DDEDEE; border: 1px solid #DDEDEE; color: #333;">
                        Login
                    </a>
                </div>
            @else
                <div class="w-30 h-30 rounded-full overflow-hidden bg-gray-200">
                    @if(empty($user->fotoProfil) || $user->fotoProfil === '-' || $user->fotoProfil === null)
                        <!-- Default guest icon jika tidak ada foto profil -->
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                                viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round"
                                    d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.25a7.25 7.25 0 0115 0v.25a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.25z" />
                            </svg>
                        </div>
                    @else
                        <img src="{{ filter_var($user->fotoProfil, FILTER_VALIDATE_URL) ? $user->fotoProfil : asset('storage/' . $user->fotoProfil) }}" alt="Profile" class="w-full h-full object-cover" />
                    @endif
                </div>
                <div class="flex flex-col items-start text-left">
                    <h1 class="text-2xl font-bold text-gray-900 mb-1">{{ $user->namaPengguna }}</h1>
                    <p class="mb-1">{{ $user->email }}</p>
                    <p class="mb-4">{{ $user->nomorTelepon }}</p>
                    <a href="#" @click.prevent="showEdit = true"
                        class="inline-flex items-center gap-2 rounded-xl px-4 py-2 text-sm font-medium transform transition-transform duration-200 hover:scale-105"
                        style="background-color: #DDEDEE; border: 1px solid #DDEDEE; color: #333;">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                            stroke="black" stroke-width="3">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.232 5.232l3.536 3.536M16.5 9.75l-9.75 9.75H5.25v-1.5l9.75-9.75z" />
                        </svg>
                        Edit Profile
                    </a>
                </div>
            @endguest
        </div>

        {{-- Modal Edit Profil Komunitas --}}
        <div x-show="showEdit" x-cloak class="fixed inset-0 z-50 flex items-center justify-center" style="background: rgba(0,0,0,0.08);">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative overflow-y-auto" style="max-height: 90vh;">
                <button @click="showEdit = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <div class="flex flex-col items-center gap-2">
                        @if(empty($user->fotoProfil) || $user->fotoProfil === '-' || $user->fotoProfil === null)
                            <!-- Default guest icon jika tidak ada foto profil -->
                            <div id="preview-foto-wrapper" class="w-24 h-24 rounded-full bg-gray-200 flex items-center justify-center border mb-2">
                                <svg id="preview-foto-guest" class="w-16 h-16 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                        d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.25a7.25 7.25 0 0115 0v.25a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.25z" />
                                </svg>
                            </div>
                        @else
                            <img id="preview-foto" src="{{ filter_var($user->fotoProfil, FILTER_VALIDATE_URL) ? $user->fotoProfil : asset('storage/' . $user->fotoProfil) }}" alt="Foto Profil" class="w-24 h-24 rounded-full object-cover border mb-2">
                        @endif
                        <input type="file" name="fotoProfil" accept="image/*" class="hidden" id="fotoProfilInput" onchange="previewFoto(event)">
                        <button type="button" onclick="document.getElementById('fotoProfilInput').click()" class="text-sm text-[#810000] underline">Ganti Foto</button>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Nama Komunitas</label>
                        <input type="text" name="namaPengguna" value="{{ $user->namaPengguna }}" class="w-full rounded-lg border px-3 py-2" required maxlength="100">
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Email</label>
                        <input type="email" name="email" value="{{ $user->email }}"
                            class="w-full rounded-lg border px-3 py-2"
                            required
                            pattern="^[a-zA-Z0-9._%+-]+@gmail\.com$"
                            title="Email harus diakhiri dengan @gmail.com">
                        <p id="email-error" class="text-red-600 text-xs mt-1" style="display:none;"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Nomor Telepon</label>
                        <input type="text" name="nomorTelepon" value="{{ $user->nomorTelepon }}"
                            class="w-full rounded-lg border px-3 py-2"
                            required
                            pattern="^08[0-9]{9,11}$"
                            minlength="11"
                            maxlength="13"
                            title="Nomor telepon harus diawali 08 dan 11-13 digit angka">
                        <p id="telepon-error" class="text-red-600 text-xs mt-1" style="display:none;"></p>
                    </div>
                    <div>
                        <label class="block text-sm font-medium mb-1">Portofolio</label>
                        <textarea name="portofolio" rows="3"
                            class="w-full rounded-lg border px-3 py-2"
                            maxlength="1000"
                            placeholder="Tulis portofolio komunitas di sini...">{{ $akunKomunitas->portofolio ?? '' }}</textarea>
                    </div>
                    <button type="submit" class="w-full bg-[#810000] text-white rounded-lg py-2 font-semibold mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>

        {{-- Tabs + Content --}}
        <div x-data="{ tab: 'all' }">
            {{-- Tabs --}}
            <div class="flex gap-16 mb-8 justify-center relative">
                <button @click="tab = 'all'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'all' ? 'text-gray-900' : ''">
                    All
                    <div x-show="tab === 'all'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-16"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>

                <button @click="tab = 'berlangsung'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'berlangsung' ? 'text-gray-900' : ''">
                    Berlangsung
                    <div x-show="tab === 'berlangsung'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-36"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>

                <button @click="tab = 'selesai'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'selesai' ? 'text-gray-900' : ''">
                    Selesai
                    <div x-show="tab === 'selesai'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-24"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>
                <div class="absolute left-0 w-full h-px bg-[#e5e7eb]" style="bottom: 0; z-index: 0;"></div>
            </div>

            {{-- All --}}
            <div x-show="tab === 'all'" x-transition>
                <div class="space-y-4">
                    @guest
                        <div class="text-center text-gray-400 py-10">Silakan login untuk melihat campaign Anda.</div>
                    @else
                        @forelse ($campaignsAll as $campaign)
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        @empty
                            <div class="text-center text-gray-400 py-10">Tidak ada campaign.</div>
                        @endforelse
                    @endguest
                </div>
            </div>

            {{-- Campaign Berlangsung --}}
            <div x-show="tab === 'berlangsung'" x-transition>
                <div class="space-y-4">
                    @guest
                        <div class="text-center text-gray-400 py-10">Silakan login untuk melihat campaign Anda.</div>
                    @else
                        @forelse ($campaignsBerlangsung as $campaign)
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        @empty
                            <div class="text-center text-gray-400 py-10">Tidak ada campaign yang sedang berlangsung.</div>
                        @endforelse
                    @endguest
                </div>
            </div>

            {{-- Campaign Selesai --}}
            <div x-show="tab === 'selesai'" x-transition>
                <div class="space-y-4">
                    @guest
                        <div class="text-center text-gray-400 py-10">Silakan login untuk melihat campaign Anda.</div>
                    @else
                        @forelse ($campaignsSelesai as $campaign)
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        @empty
                            <div class="text-center text-gray-400 py-10">Tidak ada campaign yang sudah selesai.</div>
                        @endforelse
                    @endguest
                </div>
            </div>
        </div>
    </main>

</body>

</html>

<script>
function previewFoto(event) {
    const file = event.target.files[0];
    if (!file) return;

    // Cari wrapper
    const wrapper = document.getElementById('preview-foto-wrapper');
    // Jika ada SVG guest, hapus SVG dan ganti dengan <img>
    let img = document.getElementById('preview-foto');
    if (!img) {
        // Hapus isi wrapper (SVG guest)
        wrapper.innerHTML = '';
        // Buat <img> baru
        img = document.createElement('img');
        img.id = 'preview-foto';
        img.className = 'w-24 h-24 rounded-full object-cover border';
        img.alt = 'Foto Profil';
        wrapper.appendChild(img);
    }
    // Preview gambar
    const reader = new FileReader();
    reader.onload = function(e) {
        img.src = e.target.result;
    }
    reader.readAsDataURL(file);
}

document.querySelector('form[action="{{ route('profil.update') }}"]').addEventListener('submit', function(e) {
    // Validasi email
    const emailInput = this.querySelector('input[name="email"]');
    const errorMsg = document.getElementById('email-error');
    const regex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
    let hasError = false;

    if (!regex.test(emailInput.value)) {
        errorMsg.textContent = 'Email harus diakhiri dengan @gmail.com';
        errorMsg.style.display = 'block';
        emailInput.classList.add('border-red-500');
        emailInput.focus();
        hasError = true;
    } else {
        errorMsg.textContent = '';
        errorMsg.style.display = 'none';
        emailInput.classList.remove('border-red-500');
    }

    // Validasi nomor telepon
    const telInput = this.querySelector('input[name="nomorTelepon"]');
    const telError = document.getElementById('telepon-error');
    const telRegex = /^08[0-9]{9,11}$/;
    if (!telRegex.test(telInput.value)) {
        telError.textContent = 'Nomor telepon harus diawali 08, hanya angka, dan 11-13 digit';
        telError.style.display = 'block';
        telInput.classList.add('border-red-500');
        if (!hasError) telInput.focus();
        hasError = true;
    } else {
        telError.textContent = '';
        telError.style.display = 'none';
        telInput.classList.remove('border-red-500');
    }

    if (hasError) {
        e.preventDefault();
        return false;
    }
});
</script>
