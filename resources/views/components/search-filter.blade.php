<div class="w-full flex items-center gap-4">
    {{-- Search Bar --}}
    <div class="flex-grow relative">
        <form action="{{ route('search') }}" method="GET" class="w-full" id="searchForm">
            <!-- Search Icon -->
            <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                <svg
                    class="h-5 w-5 text-[#810000]"
                    xmlns="http://www.w3.org/2000/svg"
                    fill="none"
                    viewBox="0 0 24 24"
                    stroke="currentColor"
                    stroke-width="2"
                >
                    <path
                        stroke-linecap="round"
                        stroke-linejoin="round"
                        d="M21 21l-4.35-4.35m0 0A7.5 7.5 0 104.5 4.5a7.5 7.5 0 0012.15 12.15z"
                    />
                </svg>
            </div>

            <!-- Input -->
            <input
                type="text"
                name="q"
                placeholder="Cari campaign..."
                class="w-full pl-10 pr-4 py-2 rounded-full border border-gray-300 focus:outline-none focus:ring-2 focus:ring-[#810000]"
                style="font-family: Poppins"
                value="{{ request('q') }}"
            />
        </form>
    </div>

    {{-- Filter Button & Popup --}}
    <div class="relative">
        <button
            class="group p-0 m-0 bg-transparent border-0 cursor-pointer"
            aria-label="Filter"
        >
            <svg
                xmlns="http://www.w3.org/2000/svg"
                class="h-7 w-7 stroke-current text-[#810000] group-hover:text-black"
                fill="none"
                viewBox="0 0 24 24"
                stroke-width="2"
            >
                <path
                    stroke-linecap="round"
                    stroke-linejoin="round"
                    d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2a1 1 0 01-.293.707L15 13.414V18a1 1 0 01-.553.894l-4 2A1 1 0 019 20v-6.586L3.293 6.707A1 1 0 013 6V4z"
                />
            </svg>
        </button>

        {{-- Filter Popup --}}
        <div id="filterPopup" class="hidden absolute right-0 mt-2 w-72 bg-white rounded-lg shadow-lg border border-gray-200 p-4 z-50">
            <form action="{{ route('search') }}" method="GET" class="space-y-4" id="filterForm">
                {{-- Filter Tanggal --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal Pelaksanaan</label>
                    <div class="grid grid-cols-2 gap-2">
                        <div>
                            <input type="date" name="start_date" value="{{ request('start_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#810000]">
                        </div>
                        <div>
                            <input type="date" name="end_date" value="{{ request('end_date') }}"
                                class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#810000]">
                        </div>
                    </div>
                </div>

                {{-- Filter Lokasi --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Lokasi</label>
                    <input type="text" name="location" value="{{ request('location') }}"
                        placeholder="Masukkan lokasi"
                        class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#810000]">
                </div>

                {{-- Filter Kuota --}}
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Kuota Partisipan</label>
                    <select name="quota" class="w-full px-3 py-2 border border-gray-300 rounded-md focus:outline-none focus:ring-2 focus:ring-[#810000]">
                        <option value="">Semua</option>
                        <option value="1-10" {{ request('quota') == '1-10' ? 'selected' : '' }}>1-10 orang</option>
                        <option value="11-50" {{ request('quota') == '11-50' ? 'selected' : '' }}>11-50 orang</option>
                        <option value="51-100" {{ request('quota') == '51-100' ? 'selected' : '' }}>51-100 orang</option>
                        <option value="100+" {{ request('quota') == '100+' ? 'selected' : '' }}>100+ orang</option>
                    </select>
                </div>

                {{-- Tombol Filter --}}
                <div class="flex justify-end space-x-2">
                    <button type="button" onclick="resetFilters()"
                        class="px-4 py-2 text-gray-600 hover:text-gray-800">
                        Reset
                    </button>
                    <button type="submit" id="applyFilterBtn"
                        class="px-4 py-2 bg-[#810000] text-white rounded-md hover:bg-[#6b0000] transition-colors">
                        Terapkan
                    </button>
                </div>
            </form>
        </div>
    </div>
</div>

<script>
    // Toggle popup
    document.querySelector('[aria-label="Filter"]').addEventListener('click', function(e) {
        e.stopPropagation();
        const popup = document.getElementById('filterPopup');
        popup.classList.toggle('hidden');
    });

    // Close popup when outside
    document.addEventListener('click', function(e) {
        const popup = document.getElementById('filterPopup');
        const filterButton = document.querySelector('[aria-label="Filter"]');

        if (!popup.contains(e.target) && !filterButton.contains(e.target)) {
            popup.classList.add('hidden');
        }
    });

    // Validate form pencarian
    document.getElementById('searchForm').addEventListener('submit', function(e) {
        const searchInput = this.querySelector('input[name="q"]');
        if (!searchInput.value.trim()) {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian');
        }
    });

    // Validate form filter
    document.getElementById('filterForm').addEventListener('submit', function(e) {
        const searchQuery = document.querySelector('#searchForm input[name="q"]').value;
        if (!searchQuery.trim()) {
            e.preventDefault();
            alert('Mohon masukkan kata kunci pencarian terlebih dahulu');
            return;
        }
        // Add keyword to form filter
        const hiddenInput = document.createElement('input');
        hiddenInput.type = 'hidden';
        hiddenInput.name = 'q';
        hiddenInput.value = searchQuery;
        this.appendChild(hiddenInput);
    });

    // Reset filter
    function resetFilters() {
        const searchQuery = document.querySelector('#searchForm input[name="q"]').value;
        if (!searchQuery.trim()) {
            alert('Mohon masukkan kata kunci pencarian terlebih dahulu');
            return;
        }
        window.location.href = "{{ route('search') }}?q=" + encodeURIComponent(searchQuery);
    }
</script>
