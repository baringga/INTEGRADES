@section('content')
<div x-data="registrationForm()" class="min-h-screen relative">
    <!-- Background Image -->
    <img src="{{ asset('images/cleanup-bg.png') }}" alt="Environmental cleanup" class="absolute inset-0 w-full h-full object-cover">

    <!-- Overlay -->
    <div class="absolute inset-0 bg-black/50"></div>

    <!-- Closed Modal Button -->
    <template x-if="!isOpen">
        <div class="absolute inset-0 flex items-center justify-center">
            <button @click="isOpen = true"
                class="bg-[#55a7aa] hover:bg-[#55a7aa]/90 text-white px-8 py-3 rounded-lg">
                Open Registration
            </button>
        </div>
    </template>

    <!-- Registration Modal -->
    <template x-if="isOpen">
        <div class="absolute inset-0 flex items-center justify-center p-4">
            <div class="bg-[#fcfcfc] rounded-3xl p-8 w-full max-w-md relative shadow-2xl">
                <!-- Close Button -->
                <button @click="isOpen = false"
                    class="absolute top-4 right-4 text-[#333333] hover:bg-gray-100 rounded-full p-2">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                            d="M6 18L18 6M6 6l12 12" />
                    </svg>
                </button>

                <div class="space-y-6 mt-4">
                    <!-- Nama Lengkap -->
                    <input type="text" placeholder="Nama Lengkap" x-model="form.namaLengkap"
                        class="h-14 bg-[#ddedee] border-0 rounded-2xl text-[#55a7aa] placeholder-[#55a7aa] text-lg px-6 w-full" />

                    <!-- Email -->
                    <input type="email" placeholder="Email" x-model="form.email"
                        class="h-14 bg-[#ddedee] border-0 rounded-2xl text-[#55a7aa] placeholder-[#55a7aa] text-lg px-6 w-full" />

                    <!-- Nomor Ponsel -->
                    <div class="flex gap-3">
                        <span
                            class="flex items-center h-14 bg-[#55a7aa] text-white border-0 rounded-2xl px-6 text-lg font-medium">+62</span>
                        <input type="text" placeholder="Nomor Ponsel" x-model="form.nomorPonsel"
                            class="h-14 bg-[#ddedee] border-0 rounded-2xl text-[#55a7aa] placeholder-[#55a7aa] text-lg px-6 flex-1" />
                    </div>

                    <!-- Upload KTP -->
                    <div>
                        <label class="text-[#55a7aa] text-lg font-medium mb-2 block">Kartu Tanda Penduduk</label>
                        <div class="relative">
                            <input type="file" accept="image/*" @change="handleFileUpload" class="absolute inset-0 w-full h-full opacity-0 cursor-pointer z-10" />
                            <div
                                class="h-32 bg-[#ddedee] border-2 border-dashed border-[#99cacc] rounded-2xl flex flex-col items-center justify-center text-[#55a7aa] cursor-pointer hover:bg-[#99cacc]/10 transition-colors">
                                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 mb-2" fill="none"
                                    viewBox="0 0 24 24" stroke="currentColor">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M4 16v1a2 2 0 002 2h12a2 2 0 002-2v-1M12 12v6m0 0l-3-3m3 3l3-3m6-6h-6m0 0V4m0 4l-3-3m3 3l3-3" />
                                </svg>
                                <span class="text-lg" x-text="form.ktpFileName || 'Tambahkan Foto'"></span>
                            </div>
                        </div>
                    </div>

                    <!-- Daftar -->
                    <button type="button" @click="submitForm"
                        class="w-full h-14 bg-[#810000] hover:bg-[#810000]/90 text-white rounded-2xl text-lg font-medium">
                        Daftar
                    </button>
                </div>
            </div>
        </div>
    </template>
</div>
@endsection

@section('scripts')
<!-- Alpine.js CDN -->
<script src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js" defer></script>
<script>
    function registrationForm() {
        return {
            isOpen: true,
            form: {
                namaLengkap: '',
                email: '',
                nomorPonsel: '',
                ktpFile: null,
                ktpFileName: ''
            },
            handleFileUpload(event) {
                const file = event.target.files[0];
                if (file) {
                    this.form.ktpFile = file;
                    this.form.ktpFileName = file.name;
                }
            },
            submitForm() {
                // Kirim ke server dengan fetch/Axios atau form submission
                console.log('Form submitted', this.form);
                alert("Data berhasil dikirim!");
            }
        }
    }
</script>
@endsection