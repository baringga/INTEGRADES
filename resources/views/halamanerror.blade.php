<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Halaman Tidak Ditemukan</title>
    @vite('resources/css/app.css')
</head>

<body class="mb-20">
    @include('components.navbar')

    {{-- Error 404 Page --}}
    <div class="min-h-screen bg-white flex flex-col items-center justify-center px-4">
        <div class="text-center space-y-8 max-w-md">
            {{-- Error 404 Title --}}
            <h1 class="text-xl md:text-3xl font-bold text-[#224344]">Halaman Tidak Ditemukan</h1>
            <p class="text-gray-600 text-sm md:text-base">Maaf, halaman yang kamu tuju tidak ditemukan.</p>
            {{-- Illustration --}}
            <div class="flex justify-center mb-8">
                <img src="{{ asset('ilustration.png') }}" class="max-w-full h-auto" width="250" height="150">
            </div>

            {{-- Back to Homepage Button --}}
            <a href="/dashboard" class="inline-block border-2 border-[#810000] text-[#810000] bg-transparent hover:bg-[#810000] hover:text-white rounded-full px-8 py-3 text-base font-medium transition-colors duration-200">
                Kembali ke beranda
            </a>
        </div>
    </div>
</body>

</html>
