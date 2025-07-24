<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Laporan Baru</title>
    <!-- Leaflet CSS -->
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
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
            <!-- 2. Kategori Laporan (wajib) -->
            <div>
                <label for="kategori_laporan" class="block text-sm font-medium mb-1">Kategori Laporan <span class="text-red-500">*</span></label>
                <select name="kategori_laporan" id="kategori_laporan" required class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">
                    <option value="">Pilih Kategori</option>
                    <option value="lingkungan" {{ old('kategori_laporan') == 'lingkungan' ? 'selected' : '' }}>Lingkungan</option>
                    <option value="sosial" {{ old('kategori_laporan') == 'sosial' ? 'selected' : '' }}>Sosial</option>
                    <option value="infrastruktur" {{ old('kategori_laporan') == 'infrastruktur' ? 'selected' : '' }}>Infrastruktur</option>
                    <option value="pendidikan" {{ old('kategori_laporan') == 'pendidikan' ? 'selected' : '' }}>Pendidikan</option>
                    <option value="kesehatan" {{ old('kategori_laporan') == 'kesehatan' ? 'selected' : '' }}>Kesehatan</option>
                    <option value="ekonomi" {{ old('kategori_laporan') == 'ekonomi' ? 'selected' : '' }}>Ekonomi</option>
                    <option value="keamanan" {{ old('kategori_laporan') == 'keamanan' ? 'selected' : '' }}>Keamanan</option>
                    <option value="pariwisata" {{ old('kategori_laporan') == 'pariwisata' ? 'selected' : '' }}>Pariwisata</option>
                    <option value="pertanian" {{ old('kategori_laporan') == 'pertanian' ? 'selected' : '' }}>Pertanian</option>
                    <option value="lainnya" {{ old('kategori_laporan') == 'lainnya' ? 'selected' : '' }}>Lainnya (tulis sendiri di bawah)</option>
                </select>
                <input type="text" name="kategori_laporan_custom" id="kategori_laporan_custom"
                    placeholder="Tulis kategori lain di sini (jika memilih 'Lainnya')"
                    class="mt-2 w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]"
                    value="{{ old('kategori_laporan_custom') }}">
            </div>
            <!-- 3. Kelebihan Desa (wajib) -->
            <div>
                <label for="kelebihan_desa" class="block text-sm font-medium mb-1">Kelebihan Desa <span class="text-red-500">*</span></label>
                <textarea name="kelebihan_desa" id="kelebihan_desa" required rows="2" maxlength="255"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">{{ old('kelebihan_desa') }}</textarea>
            </div>
            <!-- 4. Kekurangan Desa (wajib) -->
            <div>
                <label for="kekurangan_desa" class="block text-sm font-medium mb-1">Kekurangan Desa <span class="text-red-500">*</span></label>
                <textarea name="kekurangan_desa" id="kekurangan_desa" required rows="2" maxlength="255"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">{{ old('kekurangan_desa') }}</textarea>
            </div>
            <!-- 5. Waktu (wajib) -->
            <div>
                <label for="waktu" class="block text-sm font-medium mb-1">Waktu <span class="text-red-500">*</span></label>
                <input type="datetime-local" name="waktu" id="waktu" required value="{{ old('waktu') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">
            </div>
            <!-- 6. Judul Laporan (opsional) -->
            <div>
                <label for="judul" class="block text-sm font-medium mb-1">Judul Laporan</label>
                <input type="text" name="judul" id="judul" maxlength="255" value="{{ old('judul') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">
            </div>
            <!-- 7. Isi Laporan (opsional) -->
            <div>
                <label for="isi_pengaduan" class="block text-sm font-medium mb-1">Isi Laporan</label>
                <textarea name="isi_pengaduan" id="isi_pengaduan" rows="4" maxlength="1000"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">{{ old('isi_pengaduan') }}</textarea>
            </div>
            <!-- 8. Saran Aksi atau Harapan (opsional) -->
            <div>
                <label for="saran_aksi" class="block text-sm font-medium mb-1">Saran Aksi atau Harapan</label>
                <textarea name="saran_aksi" id="saran_aksi" rows="2" maxlength="255"
                          class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]">{{ old('saran_aksi') }}</textarea>
            </div>
            <!-- 9. Lokasi Desa (wajib) -->
            <div>
                <label for="lokasi" class="block text-sm font-medium mb-1">Lokasi Desa <span class="text-red-500">*</span></label>
                <input type="text" name="lokasi" id="lokasi-desa" maxlength="255" required value="{{ old('lokasi') }}"
                       class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#74A740]" autocomplete="off">
                <div id="suggestion-box" class="suggestion-box" style="display:none;"></div>
                <div id="map" style="height: 300px; border-radius: 0.75rem; margin-top: 0.5rem; position: relative; z-index:1;">
                    <div class="map-instruction" style="position:absolute;top:10px;left:10px;background:rgba(255,255,255,0.8);padding:4px 12px;border-radius:8px;z-index:2;">Klik pada peta untuk memilih lokasi desa</div>
                </div>
                <div id="coordinates-info" style="font-size: 12px; color: #666; margin-top: 8px; text-align: center;">
                    Koordinat: -7.281900, 112.795300
                </div>
                <input type="hidden" name="latitude" id="latitude" value="{{ old('latitude') }}">
                <input type="hidden" name="longitude" id="longitude" value="{{ old('longitude') }}">
            </div>
            <!-- 10. Foto (opsional) -->
            <div>
                <label for="foto" class="block text-sm font-medium mb-1">Foto</label>
                <input type="file" name="foto" id="foto" accept="image/*"
                       class="w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-full file:border-0 file:text-sm file:font-semibold file:bg-[#DDEDEE] file:text-[#74A740] hover:file:bg-[#c9e0e1]">
            </div>
            <div class="flex justify-end">
                <button type="submit" class="bg-[#74A740] text-white px-6 py-2 rounded-lg font-semibold hover:bg-[#a507834] transition">
                    Kirim Laporan
                </button>
            </div>
        </form>

        <!-- Tambahkan script Leaflet.js setelah form -->
        <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const LOCATIONIQ_KEY = 'pk.7a3a66a4b2e1082fa82fbcce11b0f5c9';
                var defaultLat = -7.2819;
                var defaultLng = 112.7953;
                var map = L.map('map').setView([defaultLat, defaultLng], 15);
                L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
                var marker = L.marker([defaultLat, defaultLng], {draggable:true}).addTo(map);

                const alamatInput = document.getElementById('lokasi-desa');
                const latInput = document.getElementById('latitude');
                const lngInput = document.getElementById('longitude');
                const suggestionBox = document.getElementById('suggestion-box');
                const coordinatesInfo = document.getElementById('coordinates-info');

                latInput.value = defaultLat;
                lngInput.value = defaultLng;
                coordinatesInfo.textContent = `Koordinat: ${defaultLat.toFixed(6)}, ${defaultLng.toFixed(6)}`;

                function updateCoordinatesInfo(lat, lng) {
                    if (coordinatesInfo && !isNaN(lat) && !isNaN(lng)) {
                        coordinatesInfo.textContent = `Koordinat: ${lat.toFixed(6)}, ${lng.toFixed(6)}`;
                    }
                }

                function getAddressFromCoordinates(lat, lng) {
                    if (isNaN(lat) || isNaN(lng)) {
                        alamatInput.value = 'Koordinat tidak valid';
                        alamatInput.style.color = '#999';
                        return Promise.reject('Invalid coordinates');
                    }
                    alamatInput.value = 'Mengambil alamat...';
                    alamatInput.style.color = '#666';
                    return fetch(`https://us1.locationiq.com/v1/reverse?key=${LOCATIONIQ_KEY}&lat=${lat}&lon=${lng}&format=json`)
                        .then(res => res.json())
                        .then(data => {
                            if(data.display_name) {
                                alamatInput.value = data.display_name;
                                alamatInput.style.color = '#333';
                            } else {
                                alamatInput.value = 'Alamat tidak ditemukan';
                                alamatInput.style.color = '#999';
                            }
                        })
                        .catch(error => {
                            alamatInput.value = 'Gagal mengambil alamat';
                            alamatInput.style.color = '#999';
                        });
                }

                map.on('click', function(e) {
                    var latlng = e.latlng;
                    marker.setLatLng(latlng);
                    latInput.value = latlng.lat;
                    lngInput.value = latlng.lng;
                    updateCoordinatesInfo(latlng.lat, latlng.lng);
                    getAddressFromCoordinates(latlng.lat, latlng.lng);
                    const mapInstruction = document.querySelector('.map-instruction');
                    if (mapInstruction) {
                        mapInstruction.style.opacity = '0';
                        setTimeout(() => { mapInstruction.style.display = 'none'; }, 300);
                    }
                });

                marker.on('moveend', function(e) {
                    var latlng = marker.getLatLng();
                    latInput.value = latlng.lat;
                    lngInput.value = latlng.lng;
                    updateCoordinatesInfo(latlng.lat, latlng.lng);
                    getAddressFromCoordinates(latlng.lat, latlng.lng);
                });

                getAddressFromCoordinates(defaultLat, defaultLng);
            });
        </script>
    </main>

    @include('components.footer')
</body>
</html>
