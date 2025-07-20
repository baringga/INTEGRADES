<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <title>Campaign Berhasil Dihapus</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-white min-h-screen flex items-center justify-center">

    <div class="flex flex-col md:flex-row w-full max-w-4xl bg-white rounded-lg overflow-hidden shadow-lg">

        {{-- KIRI - GAMBAR CLEANUP --}}
        <div class="w-full md:w-1/2 h-96">
            <img src="https://source.unsplash.com/featured/?trash,cleanup" alt="Cleanup" class="w-full h-full object-cover">
        </div>

        {{-- KANAN - NOTIFIKASI --}}
        <div class="w-full md:w-1/2 p-8 relative flex flex-col items-center justify-center text-center space-y-6">
            {{-- Tombol close --}}
            <a href="/" class="absolute top-4 right-4 text-gray-500 hover:text-gray-800 text-xl font-bold">&times;</a>

            {{-- Judul --}}
            <h2 class="text-2xl md:text-3xl font-bold text-gray-800">Campaign Berhasil Dihapus!</h2>

            {{-- Ilustrasi karakter --}}
            <img src="{{ asset('images/berhasil-hapus.png') }}" alt="Character" class="w-40 mx-auto">

            {{-- Tombol Aksi --}}
            <div class="space-y-3 w-full px-6">
                <a href="/dashboard" class="block border border-red-800 text-red-800 py-2 rounded-full font-semibold hover:bg-red-50 transition">Kembali ke beranda</a>
            </div>
        </div>
    </div>

</body>
</html>
