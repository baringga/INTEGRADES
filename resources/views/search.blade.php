<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cari Campaign</title>
    @vite('resources/css/app.css')
</head>
<body>
    @include('components.navbar')

    <div class="mx-20 pt-20 flex items-center">
        @include('components.search-filter')
    </div>

    <main class="mx-20 pt-10">
        @if(isset($query))
            <h1 class="text-[32px] font-[700] text-black mb-4" style="font-family: 'Poppins', sans-serif !important;">
                Hasil Pencarian: "{{ $query }}" ({{ $campaigns->total() }} Campaign)
            </h1>

            {{-- Show active filter --}}
            @if($startDate || $endDate || $location || $quota)
                <div class="mb-4 flex flex-wrap gap-2">
                    @if($startDate || $endDate)
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">
                            Tanggal: {{ $startDate ? date('d/m/Y', strtotime($startDate)) : 'Awal' }} - {{ $endDate ? date('d/m/Y', strtotime($endDate)) : 'Akhir' }}
                        </span>
                    @endif
                    @if($location)
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">
                            Lokasi: {{ $location }}
                        </span>
                    @endif
                    @if($quota)
                        <span class="px-3 py-1 bg-gray-100 rounded-full text-sm">
                            Kuota: {{ $quota }}
                        </span>
                    @endif
                </div>
            @endif

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                @forelse($campaigns as $campaign)
                    @include('components.campaign-item', ['campaign' => $campaign])
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-20">
                        @if($startDate || $endDate || $location || $quota)
                            Tidak ditemukan campaign yang sesuai dengan pencarian "{{ $query }}" dan filter yang dipilih.
                        @else
                            Tidak ditemukan campaign yang sesuai dengan pencarian "{{ $query }}"
                        @endif
                    </div>
                @endforelse
            </div>

            <x-pagination :paginator="$campaigns" />
        @endif
    </main>
</body>
</html>
