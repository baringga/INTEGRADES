<!DOCTYPE html>
    <html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Forgot Password</title>
        @vite('resources/css/app.css')
    </head>
    <body>

    <div class="flex items-center justify-center min-h-screen">
        <main class="flex flex-col items-center bg-white p-8 rounded-lg shadow-md w-full max-w-sm">
            <div class="flex justify-center mb-6">
                <img src="{{ asset('Logo.png') }}" alt="Logo" class="h-12"/>
            </div>
            <h1 class="font-semibold text-lg text-black mb-2">Konfirmasi Email Anda</h1>
            <p class="text-center text-gray-500 text-sm leading-relaxed mb-6">
                Kamu perlu mengisi email dan kata sandi untuk konfirmasi.
            </p>

            <form method="POST" action="{{ route('password.reset.check') }}" class="w-full space-y-4">
                @csrf
                <div class="mb-4">
                    <input type="email" name="email" placeholder="Email"
                        class="w-full text-sm rounded-lg py-3 px-4 focus:outline-none focus:ring-2 focus:ring-[#810000] @error('email') @enderror"
                        value="{{ old('email') }}" required
                        style="background-color: #DDEDEE; color: #6b9a9a; ::placeholder { color: #55A7AA; }">
                    @error('email')
                        <p class="text-red-500 text-sm mt-1">{{ $message }}</p>
                    @enderror
                </div>

                <button class="w-full bg-[#810000] text-white text-sm font-normal rounded-full py-3" type="submit">
                    Konfirmasi Email
                </button>
            </form>

            <div class="text-center mt-6">
                <p class="text-sm text-black">
                    Kembali ke
                    <a href="{{ route('login') }}" class="text-[#810000] cursor-pointer">Login</a>
                </p>

            </div>
        </main>
    </div>

</body>
</html>
