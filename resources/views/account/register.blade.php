<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Akun Baru</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white">

    <div class="flex items-center justify-center min-h-screen pt-4">
        <div class="flex flex-col items-center w-full">
            <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-14 mb-4" />
            <h1 class="text-2xl md:text-3xl font-bold text-black text-center mb-2 mt-2">Buat Akun Baru</h1>
            <p class="text-gray-500 text-base text-center mb-8">
                Lengkapi data-data berikut untuk mendaftar akun.
            </p>
            @if(session('success'))
                <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
                    {{ session('success') }}
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-100 text-red-700 px-4 py-2 rounded mb-4">
                    <ul class="mb-0">
                        @foreach($errors->all() as $error)
                            <li>{{ $error }}</li>
                        @endforeach
                    </ul>
                </div>
            @endif
            <form method="POST" action="{{ route('account.register') }}" class="w-full max-w-md flex flex-col gap-4">
                @csrf
                <input type="hidden" name="role" value="{{ $role ?? request('role') }}">
                <input type="text" name="name" placeholder="Nama lengkap"
                    class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required>
                <input type="email" name="email" placeholder="Email"
                    class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required>
                <div class="relative">
                    <input type="password" name="password" placeholder="Kata sandi"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required>
                </div>
                <div class="relative">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi kata sandi"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required>
                </div>
                @if(($role ?? request('role')) === 'komunitas')
                <div class="relative">
                    <textarea name="portofolio" placeholder="Portofolio komunitas"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base min-h-[100px]" required></textarea>
                </div>
                @endif
                <div class="flex items-center mt-2 mb-2">
                    <input type="checkbox" id="terms" name="terms" class="mr-2 w-5 h-5 rounded border-gray-300 focus:ring-[#74A740]">
                    <label for="terms" class="text-gray-700 text-sm">Saya setuju dengan syarat dan ketentuan yang berlaku</label>
                </div>
                <button type="submit" class="w-full bg-[#74A740] text-white rounded-full py-3 font-semibold text-base hover:bg-[#a507834] transition mt-2">
                    Daftar
                </button>
            </form>
            <div class="text-center mt-8">
                <p class="text-black text-base">Sudah memiliki akun? <a href="{{ route('login') }}" class="text-[#74A740] font-semibold">Masuk</a></p>
            </div>
        </div>
    </div>
</body>
</html>
