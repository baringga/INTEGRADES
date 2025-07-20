<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>Semua Campaign Rekomendasi</title>
    @vite('resources/css/app.css')
</head>

<body class="mb-20">
    @include('components.navbar')

    <main class="mx-20 pt-10">
        <div class="mb-4 pr-8 flex items-center justify-between">
            <h1 class="text-[32px] font-[700] text-black"
                style="font-family: 'Poppins', sans-serif !important;">
                SEMUA CAMPAIGN REKOMENDASI
            </h1>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
            @forelse($campaigns as $campaign)
                @if(!is_null($campaign->nama) && \Carbon\Carbon::parse($campaign->waktu)->isFuture())
                    @include('components.campaign-item', ['campaign' => $campaign])
                @endif
            @empty
                <div class="col-span-3 text-center text-gray-500 py-10">Belum ada campaign rekomendasi</div>
            @endforelse
        </div>

        <div class="mt-8">
            <x-pagination :paginator="$campaigns" />
        </div>
    </main>
</body>

</html>
