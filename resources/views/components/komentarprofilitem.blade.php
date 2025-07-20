<a href="{{ url('/campaign/'.$campaign_id) }}" class="block group">
    <div class="bg-white rounded-xl border border-[#ddedee] px-5 py-4 transition hover:cursor-pointer">
        <div class="flex items-center gap-2 mb-3">
            <span class="inline-flex items-center bg-[#810000] text-white text-xs px-2 py-1 rounded-3xl">
                <svg xmlns="http://www.w3.org/2000/svg" class="w-3 h-3 mr-1" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z" />
                </svg>
                {{ $nama }}
            </span>
        </div>
        <p class="text-xs text-[#b0b0b0]">{{ \Carbon\Carbon::parse($waktu)->translatedFormat('l, d F Y') }}</p>
        <p class="text-[#171717] text-sm leading-relaxed">{{ $komentar }}</p>
    </div>
</a>
