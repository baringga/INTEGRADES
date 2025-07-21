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
            Selamat datang!
        </h1>
        <p class="text-gray-700 text-base mb-10 text-center">
            Silakan pilih peran Anda untuk melanjutkan pendaftaran.
        </p>
        <div class="flex flex-col md:flex-row gap-16 items-center">
            <div class="flex flex-col items-center">
                <img src="https://images.unsplash.com/photo-1652971876875-05db98fab376?q=80&w=2029&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Volunteer"
                    class="relative z-10 rounded-lg mb-4 w-64 h-48 object-cover border-4 border-gray-200 shadow-lg">
                <h2 class="font-semibold text-xl mb-2 text-center mt-2">Volunteer Desa</h2>
                <p class="text-gray-700 text-sm text-center mb-6 w-64">
                    Bisa membuat & mengikuti campaign, serta membuat pengaduan.
                </p>
                <a href="{{ route('register', ['role' => 'volunteer_desa']) }}" class="w-full">
                    <button class="w-full bg-[#810000] text-white rounded-full py-2 font-semibold hover:bg-[#a30000] transition">
                        Daftar sebagai Volunteer
                    </button>
                </a>
            </div>
            <div class="flex flex-col items-center">
                 <img src="https://images.unsplash.com/photo-1582213782179-e0d53f98f2ca?q=80&w=2070&auto=format&fit=crop&ixlib=rb-4.1.0&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D" alt="Masyarakat"
                    class="relative z-10 rounded-lg mb-4 w-64 h-48 object-cover border-4 border-gray-200 shadow-lg">
                <h2 class="font-semibold text-xl mb-2 text-center mt-2">Masyarakat Desa</h2>
                <p class="text-gray-700 text-sm text-center mb-6 w-64">
                    Hanya bisa membuat pengaduan kondisi desa.
                </p>
                <a href="{{ route('register', ['role' => 'masyarakat_desa']) }}" class="w-full">
                    <button class="w-full bg-[#810000] text-white rounded-full py-2 font-semibold hover:bg-[#a30000] transition">
                        Daftar sebagai Masyarakat
                    </button>
                </a>
            </div>
        </div>
    </div>
</body>
</html>
