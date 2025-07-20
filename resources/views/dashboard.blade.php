<!DOCTYPE html>
    <html lang="en">

    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Dashboard</title>
        @vite('resources/css/app.css')
    </head>

    <body class="mb-20">
        @include('components.navbar')
        <div class="mx-20 pt-20 flex items-center gap-4 ">
            @include('components.search-filter')
        </div>
        <main class="mx-20 pt-10">
            <div class="mb-4 pr-8 flex items-center justify-between">
                <h1 class="text-[32px] font-[700] text-black" style="font-family: 'Poppins', sans-serif !important;">
                    @if(Auth::check() && Auth::user()->jenis_akun_id == 1)
                        CAMPAIGN YANG TERDAFTAR
                    @else
                        CAMPAIGN YANG DIBUAT
                    @endif
                </h1>
                @guest
                    <span class="text-[16px] text-gray-400 font-[600] cursor-not-allowed opacity-60"
                        style="font-family: 'Poppins', sans-serif;">
                        LIHAT SEMUA
                    </span>
                @else
                    @if (Auth::user()->jenis_akun_id == 1)
                        <a href="{{ route('campaign.followed') }}" class="text-[16px] text-[#810000] hover:underline font-[600]"
                            style="font-family: 'Poppins', sans-serif;">
                            LIHAT SEMUA
                        </a>
                    @else
                        <a href="{{ route('campaign.created') }}" class="text-[16px] text-[#810000] hover:underline font-[600]"
                            style="font-family: 'Poppins', sans-serif;">
                            LIHAT SEMUA
                        </a>
                    @endif
                @endguest
            </div>

            {{-- Grid Campaign --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                @guest
                    <div class="col-span-3 text-center text-gray-500 py-20">Login untuk melihat campaign terdaftar
                    </div>
                @else
                    @forelse($userCampaigns as $campaign)
                        @if(!is_null($campaign->nama) && \Carbon\Carbon::parse($campaign->waktu)->isFuture())
                            @include('components.campaign-item', ['campaign' => $campaign])
                        @endif
                    @empty
                        <div class="col-span-3 text-center text-gray-500 py-20">Belum ada campaign yang kamu ikuti
                        </div>
                    @endforelse
                @endguest
            </div>
        </main>
        <main class="mx-20 pt-15">
            <div class="mb-4 pr-8 flex items-center justify-between">
                <h1 class="text-[32px] font-[700] text-black" style="font-family: 'Poppins', sans-serif !important;">
                    CAMPAIGN REKOMENDASI
                </h1>
                <a href="/campaign-recommendations" class="text-[16px] text-[#810000] hover:underline font-[600]"
                    style="font-family: 'Roboto', sans-serif;">
                    LIHAT SEMUA
                </a>
            </div>


            {{-- Grid Campaign --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-3 gap-7">
                @forelse($recommendedCampaigns as $campaign)
                    @if(!is_null($campaign->nama) && \Carbon\Carbon::parse($campaign->waktu)->isFuture())
                        @include('components.campaign-item', ['campaign' => $campaign])
                    @endif
                @empty
                    <div class="col-span-3 text-center text-gray-500 py-10">Belum ada campaign rekomendasi</div>
                @endforelse
            </div>
        </main>
    </body>

    </html>
