<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Pendaftaran Berhasil</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white min-h-screen">
    @include('components.navbar')
    @if(session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-2 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    <div class="flex flex-col items-center justify-center min-h-screen">
        <div class="flex flex-col items-center">
            <h1 class="text-2xl md:text-3xl font-bold text-center mb-4 mt-8">
                Pendaftaran<br>Berhasil!
            </h1>
            <img src="{{ asset('ilustration.png') }}" alt="Pendaftaran Berhasil" class="w-72 md:w-96 mb-8" />
            <a href="{{ route('login') }}">
                <button class="bg-[#810000] text-white rounded-full px-10 py-3 font-semibold text-base hover:bg-[#a30000] transition">
                    Login
                </button>
            </a>
        </div>
    </div>
</body>
</html>
