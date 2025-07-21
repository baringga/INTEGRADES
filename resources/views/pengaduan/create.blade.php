<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Pengaduan Baru</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50">
    @include('components.navbar')

    <main class="max-w-2xl mx-auto py-10 px-4">
        <h1 class="text-3xl font-bold text-gray-800 mb-6 text-center">Formulir Pengaduan Warga</h1>

        @if ($errors->any())
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('pengaduan.store') }}" method="POST" enctype="multipart/form-data" class="bg-white p-8 rounded-lg border border-gray-200 space-y-6">
            @csrf
            <div>
                <label for="judul" class="block text-sm font-medium text-gray-700 mb-1">Judul Pengaduan</label>
                <input type="text" name="judul" id="judul" required maxlength="255" value="{{ old('judul') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">
            </div>
            <div>
                <label for="isi_pengaduan" class="block text-sm font-medium text-gray-700 mb-1">Isi Pengaduan</label>
                <textarea name="isi_pengaduan" id="isi_pengaduan" required rows="5"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">{{ old('isi_pengaduan') }}</textarea>
            </div>
            <div>
                <label for="lokasi" class="block text-sm font-medium text-gray-700 mb-1">Lokasi Kejadian</label>
                <input type="text" name="lokasi" id="lokasi" required maxlength="255" value="{{ old('lokasi') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">
            </div>
            <div>
                <label for="foto" class="block text-sm font-medium text-gray-700 mb-1">Foto (Opsional)</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#DDEDEE] file:text-[#74A740] hover:file:bg-[#c9e0e1]">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#74A740] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a507834] transition">
                    Kirim Laporan
                </button>
            </div>
        </form>
    </main>
</body>
</html>
