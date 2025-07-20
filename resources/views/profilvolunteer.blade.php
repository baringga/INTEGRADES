<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
 <title>Profil {{ isset($user) && $user ? $user->namaPengguna : (isset($akun) && $akun ? $akun->namaPengguna : 'User') }}</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    @vite('resources/css/app.css')
    <script src="//unpkg.com/alpinejs" defer></script>
</head>

<body class="mb-20" style="background-color: #FDFEFE;">
    @include('components.navbar')

    {{-- Profile Section --}}
    <main class="max-w-4xl mx-auto px-6 py-12" x-data="{ showEdit: false, tab: 'campaign' }">
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
                    <!-- Default guest icon jika tidak ada foto profil -->
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
                <div class="w-30 h-30 rounded-full overflow-hidden bg-gray-200 flex items-center justify-center">
                    @if(empty($user->fotoProfil) || $user->fotoProfil === '-' || $user->fotoProfil === null)
                        <!-- Default guest icon jika tidak ada foto profil -->
                        <svg class="w-20 h-20 text-gray-400" fill="none" stroke="currentColor" stroke-width="1.5"
                            viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M15.75 7.5a3.75 3.75 0 11-7.5 0 3.75 3.75 0 017.5 0zM4.5 19.25a7.25 7.25 0 0115 0v.25a.75.75 0 01-.75.75h-13.5a.75.75 0 01-.75-.75v-.25z" />
                        </svg>
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
        {{-- Tabs + Content --}}
        <div>
            {{-- Tabs --}}
            <div class="flex gap-16 mb-2 justify-center relative">
                <button @click="tab = 'campaign'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'campaign' ? 'text-gray-900' : ''">
                    Campaign
                    <div x-show="tab === 'campaign'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-24"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>
                <button @click="tab = 'ditandai'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'ditandai' ? 'text-gray-900' : ''">
                    Ditandai
                    <div x-show="tab === 'ditandai'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-36"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>
                <button @click="tab = 'komentar'"
                    class="relative pb-3 font-medium text-gray-500 hover:text-gray-900 transition-colors"
                    :class="tab === 'komentar' ? 'text-gray-900' : ''">
                    Komentar
                    <div x-show="tab === 'komentar'" x-transition
                        class="absolute bottom-0 left-1/2 -translate-x-1/2 h-[4px] w-24"
                        style="background-color: #CE1212; border-radius: 9999px;">
                    </div>
                </button>
                <div class="absolute left-0 w-full h-px bg-[#e5e7eb]" style="bottom: 0; z-index: 0;"></div>
            </div>

            {{-- Tab Content --}}
            <div class="mt-4">
                <div x-show="tab === 'campaign'">
                    <div class="space-y-4">
                        @forelse ($campaigns as $campaign)
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        @empty
                            <div class="text-center text-gray-400 py-10">Belum ada campaign yang kamu ikuti.</div>
                        @endforelse
                    </div>
                </div>
                <div x-show="tab === 'ditandai'">
                    <div class="space-y-4">
                        @forelse ($campaignsDitandai as $campaign)
                            @include('components.campaignprofile-item', ['campaign' => $campaign])
                        @empty
                            <div class="text-center text-gray-400 py-10">Belum ada campaign yang kamu tandai.</div>
                        @endforelse
                    </div>
                </div>
                <div x-show="tab === 'komentar'">
                    {{-- Summary Section --}}
                    <div x-data="{ tab: 'diunggah' }" class="flex flex-col gap-3">
                        <div class="flex">
                            <div class="inline-flex border border-[#e5e7eb] rounded-lg overflow-hidden">
                                <button
                                    :class="tab === 'diunggah'
                                        ?
                                        'bg-[#DDEDEE] text-black' :
                                        'bg-white text-[#b0b0b0] hover:bg-[#f5f5f5]'"
                                    class="px-6 py-2 text-sm font-medium transition focus:outline-none rounded-l-lg"
                                    @click="tab = 'diunggah'">
                                    Diunggah
                                </button>
                                <button
                                    :class="tab === 'disukai'
                                        ?
                                        'bg-[#DDEDEE] text-black' :
                                        'bg-white text-[#b0b0b0] hover:bg-[#f5f5f5]'"
                                    class="px-6 py-2 text-sm font-medium transition focus:outline-none rounded-r-lg"
                                    @click="tab = 'disukai'">
                                    Disukai
                                </button>
                            </div>
                        </div>

                        {{-- Posts --}}
                        <div class="space-y-2" x-show="tab === 'diunggah'">
                            @forelse ($komentarList as $item)
                                @include('components.komentarprofilitem', [
                                    'nama' => $item->nama_campaign,
                                    'waktu' => $item->waktu,
                                    'komentar' => $item->isi_komentar,
                                    'campaign_id' => $item->campaign_id,
                                ])
                            @empty
                                <div class="text-center text-gray-400 py-10">Belum ada komentar diunggah.</div>
                            @endforelse
                        </div>
                        <div class="space-y-6" x-show="tab === 'disukai'">
                            @forelse ($komentarDisukai as $item)
                                @include('components.komentarprofilitem', [
                                    'nama' => $item->nama_campaign,
                                    'waktu' => $item->waktu,
                                    'komentar' => $item->isi_komentar,
                                    'campaign_id' => $item->campaign_id,
                                ])
                            @empty
                                <div class="text-center text-gray-400 py-10">Belum ada komentar disukai.</div>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </div>

        {{-- Modal Edit Profil --}}
        <div x-show="showEdit" x-cloak
            class="fixed inset-0 z-50 flex items-center justify-center"
            style="background: rgba(0,0,0,0.08);">
            <div class="bg-white rounded-2xl p-8 w-full max-w-md relative">
                <button @click="showEdit = false" class="absolute top-3 right-3 text-gray-400 hover:text-gray-700 text-2xl">&times;</button>
                <form method="POST" action="{{ route('profil.update') }}" enctype="multipart/form-data" class="flex flex-col gap-4">
                    @csrf
                    <div class="flex flex-col items-center gap-2">
                        @if(empty($user->fotoProfil) || $user->fotoProfil === '-' || $user->fotoProfil === null)
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
                        <label class="block text-sm font-medium mb-1">Nama</label>
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
                    <button type="submit" class="w-full bg-[#810000] text-white rounded-lg py-2 font-semibold mt-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
        <script>
            function previewFoto(event) {
                const file = event.target.files[0];
                if (!file) return;

                // Cari wrapper
                const wrapper = document.getElementById('preview-foto-wrapper');
                let img = document.getElementById('preview-foto');
                if (!img && wrapper) {
                    // Hapus isi wrapper (SVG guest)
                    wrapper.innerHTML = '';
                    // Buat <img> baru
                    img = document.createElement('img');
                    img.id = 'preview-foto';
                    img.className = 'w-24 h-24 rounded-full object-cover border';
                    img.alt = 'Foto Profil';
                    wrapper.appendChild(img);
                }
                if (img) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        img.src = e.target.result;
                    }
                    reader.readAsDataURL(file);
                }
            }

            document.querySelector('form[action="{{ route('profil.update') }}"]').addEventListener('submit', function(e) {
                const emailInput = this.querySelector('input[name="email"]');
                const errorMsg = document.getElementById('email-error');
                const regex = /^[a-zA-Z0-9._%+-]+@gmail\.com$/;
                if (!regex.test(emailInput.value)) {
                    errorMsg.textContent = 'Email harus diakhiri dengan @gmail.com';
                    errorMsg.style.display = 'block';
                    emailInput.classList.add('border-red-500');
                    emailInput.focus();
                    e.preventDefault();
                    return false;
                } else {
                    errorMsg.textContent = '';
                    errorMsg.style.display = 'none';
                    emailInput.classList.remove('border-red-500');
                }
            });
        </script>
    </main>
</body>

</html>
