<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buat Campaign</title>
    @vite('resources/css/app.css')
    <link rel="stylesheet" href="https://unpkg.com/leaflet/dist/leaflet.css" />
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.css" />
    <script src="https://cdn.jsdelivr.net/npm/swiper/swiper-bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css"/>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr"></script>
    <script src="https://cdn.jsdelivr.net/npm/flatpickr/dist/l10n/id.js"></script>
    <style>
        #map { height: 130px; border-radius: 0.75rem; }
        .swiper-pagination {
            position: static !important;
            margin-top: 8px;
            z-index: 20;
            display: flex !important;
            justify-content: center;
            gap: 6px;
            pointer-events: auto;
        }
        .swiper-pagination-bullet {
            width: 18px;
            height: 18px;
            background: #f3eaff;
            border: none;
            opacity: 1;
            margin: 0 3px !important;
            transition: background 0.2s;
            box-shadow: none;
        }
        .swiper-pagination-bullet-active {
            background: #c1121f;
        }
        .suggestion-box{border:2px solid #74A740;border-top:none;background:#fff;box-shadow:0 4px 12px rgb(129 0 0 / .1);z-index:9999;position:absolute;top:100%;left:0;right:0;max-height:200px;overflow-y:auto;pointer-events:auto}
        .suggestion-item{border-bottom:1px solid #f0f0f0;transition:all 0.2s ease;font-size:14px;color:#333;cursor:pointer;padding:10px 16px;pointer-events:auto}
        .suggestion-item:last-child{border-bottom:none}
        .suggestion-item:hover{background:#f8f8f8;color:#74A740;padding-left:20px}
        .map-instruction{position:absolute;top:10px;left:10px;background:rgb(255 255 255 / .9);padding:8px 12px;border-radius:6px;font-size:12px;color:#666;z-index:1000;pointer-events:none;transition:opacity 0.3s ease;border:1px solid #ddd}
    </style>
</head>
<body class="bg-[#FAFAFA] min-h-screen">
    @include('components.navbar')

    <div class="flex flex-col items-center w-full pt-8">
        <div class="flex flex-row w-[90%] max-w-6xl gap-8">
            <div class="flex-1 flex flex-col items-center">
                <div class="flex items-center w-full mb-4">
                    <h1 class="text-2xl md:text-3xl font-bold text-black text-center flex-1">Buat Campaign</h1>
                </div>
                <div id="image-preview-container" class="relative w-full max-w-md h-80 rounded-xl overflow-hidden mb-1 shadow">
                    <div id="image-placeholder" class="w-full h-full bg-gray-200 flex items-center justify-center text-gray-400 text-xl font-bold">
                        Gambar Campaign
                    </div>
                    <div class="swiper mySwiper w-full h-full absolute inset-0 hidden">
                        <div class="swiper-wrapper"></div>
                    </div>
                </div>
                <div class="flex justify-center w-full mb-4">
                    <div class="swiper-pagination"></div>
                </div>
                <div class="w-full max-w-md mt-2">
                    <h2 class="font-semibold text-lg mb-1">Lokasi Campaign</h2>
                    <div class="flex items-center text-gray-700 text-sm mb-2">
                        <svg class="w-5 h-5 mr-1 text-[#225151]" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z"/>
                            <path stroke-linecap="round" stroke-linejoin="round" d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/>
                        </svg>
                        <span id="lokasi-text">Pilih lokasi pada peta</span>
                    </div>
                    <div id="map" style="height: 180px; border-radius: 0.75rem; margin-top: 0.5rem; position: relative;">
                        <div class="map-instruction">Klik pada peta untuk memilih lokasi</div>
                    </div>
                    <div id="coordinates-info" style="font-size: 12px; color: #666; margin-top: 8px; text-align: center;">
                        Koordinat: -7.281900, 112.795300
                    </div>
                </div>
            </div>
            <div class="flex-1 flex flex-col items-center">
                @if(session('success'))
                    <div class="bg-green-100 text-green-700 px-4 py-2 rounded-lg mb-4 w-full max-w-md">
                        {{ session('success') }}
                    </div>
                @endif
                @if ($errors->any())
                    <div class="bg-red-100 text-red-700 px-4 py-2 rounded-lg mb-4 w-full max-w-md">
                        <ul class="list-disc list-inside">
                            @foreach ($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                <form action="{{ route('campaign.store') }}" method="POST" enctype="multipart/form-data" class="w-full max-w-md flex flex-col gap-4 bg-white rounded-2xl p-6 shadow" id="campaign-form">
                    @csrf
                    <label for="gambar-latar-input" id="gambar-latar-label"
                        class="flex flex-col items-center justify-center border-2 border-dashed border-[#55A7AA] bg-[#DDEDEE] rounded-xl py-8 cursor-pointer mb-2 w-full max-w-md mx-auto text-center">
                        <div class="flex justify-center w-full">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8 text-[#55A7AA] mb-2" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5-5m0 0l5 5m-5-5v12" />
                            </svg>
                        </div>
                        <span class="text-[#55A7AA] font-semibold">
                            Upload Gambar Kegiatan<br>
                            Deskripsi Campaign
                        </span>
                        <input type="file" name="gambar_latar[]" accept="image/*" class="hidden" id="gambar-latar-input" multiple>
                    </label>
                    <input type="text" name="nama_campaign" placeholder="Nama campaign"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required value="{{ old('nama_campaign') }}">
                    <textarea name="deskripsi_campaign" placeholder="Deskripsi campaign"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base resize-none" rows="2" required>{{ old('deskripsi_campaign') }}</textarea>
                    <div class="relative">
                        <input type="text" name="waktu" placeholder="dd-mm-yyyy hh:mm"
                            class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base pr-10"
                            required id="waktu" value="{{ old('waktu') }}">
                        <span class="absolute right-4 top-1/2 -translate-y-1/2 text-[#55A7AA]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                            </svg>
                        </span>
                    </div>
                    <p class="text-xs text-[#74A740] mt-1 mb-2">Format: dd-mm-yyyy hh:mm (contoh: 31-12-2024 14:30)</p>
                    <input type="number" name="kuota_partisipan" placeholder="Kuota Partisipan"
                        class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base" required value="{{ old('kuota_partisipan') }}">
                    <div class="relative">
                        <input type="text" name="alamat_campaign" placeholder="Alamat campaign lengkap"
                            class="rounded-xl py-3 px-5 w-full bg-[#DDEDEE] text-[#55A7AA] placeholder-[#55A7AA] focus:outline-none focus:ring-2 focus:ring-[#74A740] text-base pl-10" id="alamat-campaign" required autocomplete="off">
                        <span class="absolute left-3 top-1/2 -translate-y-1/2 text-[#55A7AA]">
                            <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 11c1.104 0 2-.896 2-2s-.896-2-2-2-2 .896-2 2 .896 2 2 2z"/>
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 22s8-4.5 8-10a8 8 0 10-16 0c0 5.5 8 10 8 10z"/>
                            </svg>
                        </span>
                        <div id="suggestion-box" class="suggestion-box" style="display:none;"></div>
                    </div>
                    <input type="hidden" name="latitude" id="latitude">
                    <input type="hidden" name="longitude" id="longitude">

                    <button type="submit" class="w-full bg-[#74A740] text-white rounded-full py-3 font-semibold text-base hover:bg-[#a507834] transition mt-2">
                        Buat
                    </button>
                </form>
            </div>
        </div>
    </div>

    <!-- Modal Notifikasi -->
    <div id="modal-success" class="fixed inset-0 z-50 items-center justify-center backdrop-blur-sm {{ session('success') ? 'flex' : 'hidden' }}">
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg flex flex-col items-center px-10 py-8 relative max-w-md w-full">
            <a href="{{ url('/dashboard') }}" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold"> × </a>
            <h2 class="text-2xl md:text-3xl font-bold text-[#225151] text-center mb-2">Campaign<br>Berhasil Dibuat!</h2>
            <img src="{{ asset('ilustration.png') }}" class="w-56 md:w-72 mb-6" />
            <div class="flex flex-col gap-2 w-full">
                <a href="{{ url('/dashboard') }}" class="w-full">
                    <button class="w-full bg-[#74A740] text-white rounded-full py-3 font-semibold text-base hover:bg-[#a507834] transition mb-3">Kembali ke Dashboard</button>
                </a>
                @if(session('new_campaign_id'))
                <a href="{{ route('detailcam', session('new_campaign_id')) }}" class="w-full">
                    <button class="w-full border-2 border-[#74A740] text-[#74A740] rounded-full py-3 font-semibold text-base hover:bg-[#f5eaea] transition">Lihat Campaign</button>
                </a>
                @endif
            </div>
        </div>
    </div>
    <div id="modal-error" class="fixed inset-0 z-50 items-center justify-center backdrop-blur-sm {{ session('error') ? 'flex' : 'hidden' }}">
        <div class="bg-white/80 backdrop-blur-md rounded-2xl shadow-lg flex flex-col items-center px-10 py-8 relative max-w-md w-full">
            <button onclick="document.getElementById('modal-error').classList.add('hidden')" class="absolute top-4 right-4 text-gray-500 hover:text-gray-700 text-2xl font-bold">×</button>
            <h2 class="text-2xl md:text-3xl font-bold text-[#a507834] text-center mb-2">Gagal Membuat Campaign!</h2>
            <img src="{{ asset('ilustration.png') }}" class="w-56 md:w-72 mb-6" />
            <div id="modal-error-message" class="w-full text-center text-[#a507834] font-semibold mb-4">{{ session('error') }}</div>
            <button onclick="document.getElementById('modal-error').classList.add('hidden')" class="w-full bg-[#f5eaea] text-[#a507834] rounded-full py-3 font-semibold text-base hover:bg-[#ffeaea] transition mb-3">Tutup</button>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function() {
            @if(session('success'))
                const modalSuccess = document.getElementById('modal-success');
                modalSuccess.classList.remove('hidden');
                modalSuccess.classList.add('flex');
            @endif
            @if(session('error'))
                const modalError = document.getElementById('modal-error');
                modalError.classList.remove('hidden');
                modalError.classList.add('flex');
            @endif
        });
    </script>

    <script src="https://unpkg.com/leaflet/dist/leaflet.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            // --- LOGIKA GAMBAR (Baru) ---
            const imageInput = document.getElementById('gambar-latar-input');
            const previewContainer = document.getElementById('image-preview-container');
            const swiperContainer = previewContainer.querySelector('.mySwiper');
            const placeholder = document.getElementById('image-placeholder');
            const uploadLabel = document.getElementById('gambar-latar-label');
            const MAX_IMAGES = 3;
            let fileDataTransfer = new DataTransfer();
            let swiperInstance = null;

            function updateSwiperAndUI() {
                if (swiperInstance) {
                    swiperInstance.destroy(true, true);
                    swiperInstance = null;
                }
                const files = fileDataTransfer.files;
                const swiperWrapper = swiperContainer.querySelector('.swiper-wrapper');
                swiperWrapper.innerHTML = '';
                if (files.length > 0) {
                    swiperContainer.classList.remove('hidden');
                    placeholder.classList.add('hidden');
                    for (let i = 0; i < files.length; i++) {
                        const file = files[i];
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide flex items-center justify-center relative';
                        slide.innerHTML = `<img src="${URL.createObjectURL(file)}" alt="Campaign Image" class="w-full h-full object-cover" />
                            <button type="button" class="remove-image-btn" data-index="${i}" style="position:absolute;top:8px;right:8px;background:rgba(255,255,255,0.8);border:none;border-radius:50%;width:24px;height:24px;display:flex;align-items:center;justify-content:center;cursor:pointer;font-size:16px;">&times;</button>`;
                        swiperWrapper.appendChild(slide);
                    }
                    setTimeout(() => {
                        swiperInstance = new Swiper(swiperContainer, {
                            loop: false,
                            pagination: {
                                el: document.querySelector('.swiper-pagination'),
                                clickable: true,
                                dynamicBullets: false,
                            },
                        });
                    }, 0);
                } else {
                    swiperContainer.classList.add('hidden');
                    placeholder.classList.remove('hidden');
                }
                uploadLabel.style.display = files.length >= MAX_IMAGES ? 'none' : 'flex';
            }

            imageInput.addEventListener('change', function(event) {
                const files = Array.from(event.target.files);
                const currentCount = fileDataTransfer.files.length;
                const filesToAdd = files.slice(0, MAX_IMAGES - currentCount);

                if (filesToAdd.length < files.length) {
                    alert(`Anda hanya bisa menambahkan ${MAX_IMAGES} gambar. Hanya ${filesToAdd.length} gambar yang ditambahkan.`);
                }

                filesToAdd.forEach(file => {
                    fileDataTransfer.items.add(file);
                });

                imageInput.files = fileDataTransfer.files;
                updateSwiperAndUI();
            });

            previewContainer.addEventListener('click', function(e) {
                const removeBtn = e.target.closest('.remove-image-btn');
                if (removeBtn) {
                    const indexToRemove = parseInt(removeBtn.getAttribute('data-index'));
                    const newFileDataTransfer = new DataTransfer();
                    for (let i = 0; i < fileDataTransfer.files.length; i++) {
                        if (i !== indexToRemove) {
                            newFileDataTransfer.items.add(fileDataTransfer.files[i]);
                        }
                    }
                    fileDataTransfer = newFileDataTransfer;
                    imageInput.files = fileDataTransfer.files;
                    updateSwiperAndUI();
                }
            });

            updateSwiperAndUI();

            // --- LOGIKA MAP & ALAMAT ---
            const LOCATIONIQ_KEY = 'pk.7a3a66a4b2e1082fa82fbcce11b0f5c9';
            var defaultLat = -7.2819;
            var defaultLng = 112.7953;
            var map = L.map('map').setView([defaultLat, defaultLng], 15);
            L.tileLayer('https://{s}.tile.openstreetmap.org/{z}/{x}/{y}.png', { attribution: '© OpenStreetMap contributors' }).addTo(map);
            var marker = L.marker([defaultLat, defaultLng], {draggable:true}).addTo(map);

            const alamatInput = document.getElementById('alamat-campaign');
            const latInput = document.getElementById('latitude');
            const lngInput = document.getElementById('longitude');
            const suggestionBox = document.getElementById('suggestion-box');
            const coordinatesInfo = document.getElementById('coordinates-info');
            const lokasiText = document.getElementById('lokasi-text');

            // Set nilai awal
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
                            if (lokasiText) lokasiText.textContent = data.display_name;
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

            alamatInput.addEventListener('input', function() {
                var query = alamatInput.value;
                if(query.length < 3) {
                    suggestionBox.style.display = 'none';
                    return;
                }
                clearTimeout(alamatInput.searchTimeout);
                alamatInput.searchTimeout = setTimeout(() => {
                    fetch(`https://us1.locationiq.com/v1/autocomplete?key=${LOCATIONIQ_KEY}&q=${encodeURIComponent(query)}&limit=5`)
                        .then(res => res.json())
                        .then(data => {
                            suggestionBox.innerHTML = '';
                            if(Array.isArray(data) && data.length > 0) {
                                data.forEach((item, index) => {
                                    var div = document.createElement('div');
                                    div.className = 'suggestion-item';
                                    div.textContent = item.display_name;
                                    div.setAttribute('data-index', index);
                                    div.addEventListener('click', function(e) {
                                        e.preventDefault();
                                        e.stopPropagation();
                                        alamatInput.value = item.display_name;
                                        alamatInput.style.color = '#333';
                                        latInput.value = item.lat;
                                        lngInput.value = item.lon;
                                        marker.setLatLng([item.lat, item.lon]);
                                        map.setView([item.lat, item.lon], 16);
                                        updateCoordinatesInfo(item.lat, item.lon);
                                        suggestionBox.style.display = 'none';
                                        if (lokasiText) lokasiText.textContent = item.display_name;
                                    });
                                    div.addEventListener('mouseenter', function() {
                                        this.style.background = '#f8f8f8';
                                        this.style.color = '#74A740';
                                        this.style.paddingLeft = '20px';
                                    });
                                    div.addEventListener('mouseleave', function() {
                                        this.style.background = '';
                                        this.style.color = '';
                                        this.style.paddingLeft = '10px';
                                    });
                                    suggestionBox.appendChild(div);
                                });
                                suggestionBox.style.display = 'block';
                            } else {
                                suggestionBox.innerHTML = '<div class="suggestion-item" style="color: #999; padding: 10px 16px;">Tidak ada hasil ditemukan</div>';
                                suggestionBox.style.display = 'block';
                            }
                        })
                        .catch(error => {
                            suggestionBox.innerHTML = '<div class="suggestion-item" style="color: #999; padding: 10px 16px;">Gagal memuat saran lokasi</div>';
                            suggestionBox.style.display = 'block';
                        });
                }, 300);
            });

            alamatInput.addEventListener('blur', function() {
                setTimeout(() => {
                    const isMouseOverSuggestion = suggestionBox.matches(':hover');
                    if (!isMouseOverSuggestion) {
                        suggestionBox.style.display = 'none';
                    }
                }, 300);
            });

            suggestionBox.addEventListener('mouseleave', function() {
                setTimeout(() => {
                    if (!alamatInput.matches(':focus')) {
                        suggestionBox.style.display = 'none';
                    }
                }, 200);
            });

            alamatInput.addEventListener('keydown', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    const firstSuggestion = suggestionBox.querySelector('.suggestion-item');
                    if (firstSuggestion && suggestionBox.style.display !== 'none') {
                        firstSuggestion.click();
                    }
                }
            });

            // Date picker
            flatpickr("#waktu", { enableTime: true, dateFormat: "d-m-Y H:i", time_24hr: true, locale: "id" });

            // Validasi form sebelum submit
            const form = document.getElementById('campaign-form');
            form.addEventListener('submit', function(e) {
                const lat = parseFloat(latInput.value);
                const lng = parseFloat(lngInput.value);
                if (isNaN(lat) || isNaN(lng)) {
                    e.preventDefault();
                    alert('Koordinat lokasi tidak valid. Silakan pilih lokasi dari peta atau dropdown.');
                    return false;
                }
                if (!alamatInput.value || alamatInput.value.trim() === '') {
                    e.preventDefault();
                    alert('Alamat lokasi harus diisi.');
                    return false;
                }
            });

            // Panggil sekali saat load awal
            getAddressFromCoordinates(defaultLat, defaultLng);
        });
    </script>
</body>
</html>
