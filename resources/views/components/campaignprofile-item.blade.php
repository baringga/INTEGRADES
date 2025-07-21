@php
    use Illuminate\Support\Str;
    use Carbon\Carbon;

    $cover = $campaign->coverImage?->gambar;
    $isUrl = $cover && (Str::startsWith($cover, ['http://', 'https://']));

    $now = now();
    $waktu = Carbon::parse($campaign->waktu);

    if ($now->lt($waktu)) {
        $status = 'Berlangsung';
        $bg = '#44709e';
    } else {
        $status = 'Selesai';
        $bg = '#67a54b';
    }
@endphp

<main ... x-data="{ showEdit: false, tab: 'campaign_diikuti' }">
    <a href="{{ url('/campaign/'.$campaign->id) }}" class="block group">
        <div class="relative h-32 rounded-2xl overflow-hidden cursor-pointer transition-transform hover:scale-[1.02]">
            <img src="{{ $isUrl ? $cover : asset('storage/' . $cover) }}"
                 alt="{{ $campaign->nama }}"
                 class="w-full h-full object-cover" />
            <div class="absolute inset-0 bg-black" style="opacity:0.3;"></div>
            <div class="absolute inset-0 flex items-center justify-between p-6">
                <div>
                    <h3 class="text-white text-xl font-semibold mb-4">{{ $campaign->nama }}</h3>
                    <span class="px-3 py-1 rounded-full text-[12px] inline-flex items-center gap-1"
                          style="background: {{ $bg }}; color: #fff;">
                        <!-- SVG Icon Kalender Putih -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-4 h-4 text-white" fill="none" viewBox="0 0 24 24"
                            stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                        </svg>
                        {{ $status }}
                    </span>
                </div>
                <span
                    class="bg-white text-black rounded-full border-0 transition-all inline-flex items-center justify-center w-10 h-10 hover:bg-gray-200">
                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24"
                        stroke="currentColor" stroke-width="2">
                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7" />
                    </svg>
                </span>
            </div>
        </div>
    </a>
</main>
