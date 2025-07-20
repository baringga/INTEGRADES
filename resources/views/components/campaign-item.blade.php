@php use Illuminate\Support\Str; @endphp

<a href="{{ url('/campaign/'.$campaign->id) }}" class="block max-w-sm bg-white rounded-2xl overflow-hidden border transition-transform hover:scale-[1.03]"
    style="border-color: rgba(0, 0, 0, 0.15);">
    @if($campaign->coverImage && $campaign->coverImage->gambar)
        @php
            $gambar = $campaign->coverImage->gambar;
            $isUrl = Str::startsWith($gambar, ['http://', 'https://']);
            // FLAG{PAI--DelonTop3BjierKelazz}
        @endphp
        <img src="{{ $isUrl ? $gambar : asset('storage/' . $gambar) }}" alt="Gambar item" class="w-full h-52 object-cover">
    @else
        <div class="w-full h-52 bg-gray-200 flex items-center justify-center text-gray-400 text-xl">No Image</div>
    @endif

    <div class="p-6 min-h-[220px] flex flex-col justify-between">
        <div>
            <h3 class="text-[16px] mt-2 font-semibold line-clamp-1">{{ $campaign->nama }}</h3>
            <p class="text-[16px] mt-4 text-gray-800 line-clamp-5">{{ $campaign->deskripsi }}</p>
        </div>
        <div>
            <p class="text-[10px] mt-6 font-semibold">Peserta terdaftar</p>
            <div class="flex items-center justify-between ">
                @php
                    $kuota = $campaign->kuota_partisipan;
                    $jumlah = $campaign->partisipanCampaigns->count();
                    $persen = $kuota > 0 ? min(100, round(($jumlah / $kuota) * 100)) : 0;
                @endphp
                <div class="flex-1 h-3 bg-gray-200 rounded-full overflow-hidden mr-4">
                    <div class="h-full" style="width: {{ $persen }}%; background-color: #3B9E51;"></div>
                </div>
                <button onclick="{{ url('/campaign/'.$campaign->id) }}"
                    class="text-xs px-3 py-2 text-white bg-[#810000] border border-[#810000] rounded-lg hover:bg-transparent hover:text-[#810000] hover:border whitespace-nowrap">
                    LIHAT DETAIL
                </button>
            </div>
        </div>
    </div>
</a>
