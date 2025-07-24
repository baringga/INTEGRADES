@extends('layouts.app')

@section('title', 'Form Pendaftaran')

@section('content')

<div class="min-h-screen flex items-center justify-center bg-[#DDEDEE] p-10">
    <div class="bg-white rounded-xl shadow max-w-5xl w-full flex flex-col md:flex-row overflow-hidden">
        <!-- Gambar di kiri -->
        <div>
            <img src="https://images.unsplash.com/photo-1506744038136-46273834b3fb?auto=format&fit=crop&w=600&q=80"
                alt="Campaign"
                class="object-cover w-full h-full rounded-r-none shadow-lg" />
        </div>

        <!-- Form di kanan -->
        <div class="flex-1 p-8 flex flex-col justify-center">
            <h2 class="text-2xl font-bold mb-6 text-center">Daftar Partisipan Campaign</h2>
            <form method="POST" action="{{ route('partisipan.store', $campaign_id) }}" class="flex-1 flex flex-col justify-center">
                @csrf
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-600">Nama Lengkap</label>
                    <input
                        type="text"
                        name="nama"
                        class="w-full rounded-xl px-3 py-2 bg-[#DDEDEE] text-[#055A7A] focus:ring-2 focus:ring-[#055A7A] focus:outline-none"
                        required
                        value="{{ auth()->user()->namaPengguna ?? '' }}">
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-600">Email</label>
                    <input
                        type="email"
                        name="email"
                        id="email"
                        class="w-full rounded-xl px-3 py-2 bg-[#DDEDEE] text-[#055A7A]"
                        required
                        value="{{ old('email', auth()->user()->email ?? '') }}"
                        oninput="validateEmail()">
                    <div id="email-error" class="text-red-600 text-sm mt-1"></div>
                    @error('email')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-6">
                    <label class="block mb-1 font-semibold text-gray-600">Nomor Telepon</label>
                    <input
                        type="text"
                        name="nomorTelepon"
                        id="nomorTelepon"
                        class="w-full rounded-xl px-3 py-2 bg-[#DDEDEE] text-[#055A7A]"
                        required
                        maxlength="14"
                        pattern="[0-9]+"
                        inputmode="numeric"
                        oninput="this.value = this.value.replace(/[^0-9]/g, '').slice(0,14); validatePhone()"
                        title="Nomor telepon hanya boleh angka dan maksimal 14 digit"
                        value="{{ old('nomorTelepon', auth()->user()->nomorTelepon ?? '') }}">
                    <div id="phone-error" class="text-red-600 text-sm mt-1"></div>
                    @error('nomorTelepon')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <div class="mb-4">
                    <label class="block mb-1 font-semibold text-gray-600">Motivasi/URL Portofolio</label>
                    <textarea
                        name="motivasi"
                        class="w-full rounded-xl px-3 py-2 bg-[#DDEDEE] text-[#055A7A] focus:ring-2 focus:ring-[#055A7A] focus:outline-none"
                        maxlength="200"
                        rows="3"
                        placeholder="Ceritakan motivasi Anda mengikuti campaign ini dan sebagai pendukung sertakan URL portofolio kamu">{{ old('motivasi') }}</textarea>
                    @error('motivasi')
                    <div class="text-red-600 text-sm mt-1">{{ $message }}</div>
                    @enderror
                </div>
                <button type="submit" class="w-full bg-[#74A740] text-white py-2 rounded-full hover:bg-[#0778A8] transition">
                    Daftar
                </button>
            </form>
        </div>
    </div>

</div>

@if(session('berhasil'))
    <div id="modal-berhasil" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-lg flex flex-col items-center px-10 py-8 relative max-w-md w-full">
            <button onclick="window.location.href='{{ route('dashboard') }}'" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
            <h2 class="text-2xl md:text-3xl font-bold text-[#224344] text-center mb-2">Pendaftaran Berhasil!</h2>
            <img src="{{ asset('ilustration.png') }}" class="w-56 md:w-72 mb-6" />
            <a href="{{ route('dashboard') }}" class="w-full">
                <button class="w-full bg-[#74A740] text-white rounded-full py-3 font-semibold text-base hover:bg-[#a507834] transition mb-3">Kembali ke beranda</button>
            </a>
        </div>
    </div>
@endif

@if(session('penuh'))
    <div id="modal-penuh" class="fixed inset-0 z-50 flex items-center justify-center bg-black/40 backdrop-blur-sm">
        <div class="bg-white rounded-2xl shadow-lg flex flex-col items-center px-10 py-8 relative max-w-md w-full">
            <button onclick="window.location.href='{{ route('dashboard') }}'" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
            <h2 class="text-2xl md:text-3xl font-bold text-[#a507834] text-center mb-2">Maaf, campaign sudah penuh!</h2>
            <img src="{{ asset('ilustration.png') }}" class="w-56 md:w-72 mb-6" />
            <a href="{{ route('dashboard') }}" class="w-full">
                <button class="w-full bg-[#74A740] text-white rounded-full py-3 font-semibold text-base hover:bg-[#a507834] transition mb-3">Kembali ke beranda</button>
            </a>
        </div>
    </div>
@endif

<script>
    function validateEmail() {
        const email = document.getElementById('email').value;
        const errorDiv = document.getElementById('email-error');
        const regex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
        if (email && !regex.test(email)) {
            errorDiv.textContent = 'Format email tidak valid.';
        } else {
            errorDiv.textContent = '';
        }
    }

    function validatePhone() {
        const phone = document.getElementById('nomorTelepon').value;
        const errorDiv = document.getElementById('phone-error');
        if (phone && (!/^[0-9]+$/.test(phone) || phone.length < 9 || phone.length > 15)) {
            errorDiv.textContent = 'FORMAT nomor telepon harus 9-15 digit angka.';
        } else {
            errorDiv.textContent = '';
        }
    }
</script>
@endsection
