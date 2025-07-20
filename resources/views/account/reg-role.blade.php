<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Daftar Akun</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-white">
    @include('components.navbar')
    <div class="flex flex-col items-center justify-center min-h-screen pt-8">
        <h1 class="text-4xl font-bold text-[#810000] mb-2 text-center mt-8">
            Selamat datang di Bersih.in!
        </h1>
        <p class="text-gray-700 text-base mb-10 text-center">
            Silakan pilih peran yang kamu inginkan.
        </p>
        <div class="flex flex-row gap-16 items-center">
            <!-- Komunitas Card -->
            <div class="flex flex-col items-center">
                <div class="relative">
                    <div class="absolute -left-8 top-1/2 -translate-y-1/2 w-40 h-32 bg-gray-300 rounded-lg opacity-60"></div>
                    <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Komunitas"
                        class="relative z-10 rounded-lg mb-4 w-56 h-40 object-cover border-4 border-blue-300 shadow-lg ring-4 ring-blue-200">
                </div>
                <h2 class="font-semibold text-xl mb-2 text-center mt-2">Komunitas</h2>
                <p class="text-gray-700 text-sm text-center mb-6 w-64">
                    Akun komunitas membantu komunitas kebersihan membuat <i>event</i> dan mencari partisipan.
                </p>
                <a href="{{ route('register', ['role' => 'komunitas']) }}">
                    <button class="w-56 bg-[#810000] text-white rounded-full py-2 font-semibold hover:bg-[#a30000] transition">
                        Pilih
                    </button>
                </a>
            </div>
            <!-- Volunteer Card -->
            <div class="flex flex-col items-center">
                <div class="relative">
                    <div class="absolute -left-8 top-1/2 -translate-y-1/2 w-40 h-32 bg-gray-300 rounded-lg opacity-60"></div>
                    <img src="https://images.unsplash.com/photo-1652971876875-05db98fab376?q=80&w=2029&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Volunteer"
                        class="relative z-10 rounded-lg mb-4 w-56 h-40 object-cover border-4 border-blue-300 shadow-lg ring-4 ring-blue-200">
                </div>
                <h2 class="font-semibold text-xl mb-2 text-center mt-2">Volunteer</h2>
                <p class="text-gray-700 text-sm text-center mb-6 w-64">
                    Akun volunteer untuk melihat dan mengikuti campaign yang dibuat oleh komunitas.
                </p>
                <a href="{{ route('register', ['role' => 'volunteer']) }}">
                    <button class="w-56 bg-[#810000] text-white rounded-full py-2 font-semibold hover:bg-[#a30000] transition">
                        Pilih
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
