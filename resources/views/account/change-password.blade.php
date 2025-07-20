<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Ubah Password</title>
        @vite('resources/css/app.css')
    </head>
    <body>
    <div class="flex items-center justify-center min-h-screen">
        <main class="flex flex-col items-center bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-12"/>
            </div>
            <h1 class="font-semibold text-lg text-black mb-2">Buat kata sandi yang kuat</h1>
            <p class="text-center text-gray-500 text-sm leading-relaxed mb-6">
                Kata sandi minimal 6 karakter yang menyertakan angka, huruf, simbol
            </p>

            <form method="POST" action="{{ route('password.update') }}" class="w-full space-y-4">
                @csrf
                <input type="hidden" name="email" value="{{ session('reset_email') }}">
                <div class="mb-4 relative">
                    <input type="password" name="password" placeholder="Kata sandi"
                        class="w-full text-sm rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#810000] @error('password') border-red-500 @enderror"
                        required
                        style="background-color: #DDEDEE; color: #6b9a9a; ::placeholder { color: #55A7AA; }">
                    <i aria-hidden="true" class="fas fa-eye-slash absolute right-3 top-1/2 -translate-y-1/2 text-[#6b9a9a] cursor-pointer"></i>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <div class="mb-4 relative">
                    <input type="password" name="password_confirmation" placeholder="Konfirmasi Kata sandi"
                        class="w-full text-sm rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#810000] @error('password') border-red-500 @enderror"
                        required
                        style="background-color: #DDEDEE; color: #6b9a9a; ::placeholder { color: #55A7AA; }">
                    <i aria-hidden="true" class="fas fa-eye-slash absolute right-3 top-1/2 -translate-y-1/2 text-[#6b9a9a] cursor-pointer"></i>
                    @error('password')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>
                <button class="w-full bg-[#810000] text-white text-sm font-normal rounded-full py-3" type="submit">
                    Reset Kata Sandi
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-black">
                    Sudah ingat password? Kembali ke
                    <a href="{{ route('login') }}" class="text-[#810000] cursor-pointer">Login</a>
                </p>

            </div>
        </main>
    </div>

</body>
</html>
