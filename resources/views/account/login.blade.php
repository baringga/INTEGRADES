<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Masuk Akun</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.navbar')
    <div class="flex items-center justify-center min-h-screen">
        <main class="flex flex-col items-center bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-12"/>
            </div>
            <h1 class="font-semibold text-lg text-black mb-2">Selamat Datang,</h1>
            <p class="text-center text-gray-500 text-sm leading-relaxed mb-6">
                Kamu perlu mengisi email dan kata sandi untuk masuk.
            </p>

            @if (session('success'))
                <div class="mb-4 p-3 rounded bg-green-100 text-green-800 text-sm text-center">
                    {{ session('success') }}
                </div>
            @endif

            <form method="POST" action="{{ route('login') }}" class="w-full space-y-4">
                @csrf
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email"
                        class="w-full text-sm rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#74A740] @error('email') border-red-500 @enderror"
                        value="{{ old('email') }}" required
                        style="background-color: #DDEDEE; color: #6b9a9a; ::placeholder { color: #55A7AA; }">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 relative">
                    <input type="password" name="password" placeholder="Kata sandi"
                        class="w-full text-sm rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#74A740] @error('password') border-red-500 @enderror"
                        required
                        style="background-color: #DDEDEE; color: #6b9a9a; ::placeholder { color: #55A7AA; }">
                    <i aria-hidden="true" class="fas fa-eye-slash absolute right-3 top-1/2 -translate-y-1/2 text-[#6b9a9a] cursor-pointer"></i>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button class="w-full bg-[#74A740] text-white text-sm font-normal rounded-full py-3" type="submit">
                    Masuk
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-black">
                    Belum memiliki akun?
                    <a href="{{ route('register') }}" class="text-[#74A740] cursor-pointer">Daftar</a>
                </p>
                <a href="{{ route('password.request') }}" class="text-sm text-gray-500 mt-2 block">Lupa Password</a>
            </div>
        </main>
    </div>

</body>
</html>
