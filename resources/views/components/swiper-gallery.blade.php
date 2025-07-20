
{{-- filepath: resources/views/components/swiper-gallery.blade.php --}}
@props(['gambar' => []])

<div>
    <div class="swiper mySwiper rounded-xl overflow-hidden shadow-lg w-full h-64 md:h-96">
        <div class="swiper-wrapper">
            @forelse($gambar as $g)
                @php
                    $isUrl = filter_var($g->gambar, FILTER_VALIDATE_URL);
                    $src = $isUrl ? $g->gambar : asset('storage/' . $g->gambar);
                @endphp
                <div class="swiper-slide flex items-center justify-center bg-gray-200">
                    <img src="{{ $src }}" alt="Gambar Campaign" class="object-cover w-full h-full" />
                </div>
            @empty
                <div class="swiper-slide flex items-center justify-center bg-gray-200">
                    <img src="{{ asset('campaignprofile.jpg') }}" alt="Default Campaign" class="object-cover w-full h-full" />
                </div>
            @endforelse
        </div>
    </div>
    <div class="swiper-pagination mt-4"></div>
</div>