<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>{{ $campaign->nama }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <script src="//unpkg.com/alpinejs" defer></script>
    <!-- Tambahkan SweetAlert2 di <head> jika belum -->
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>

<body class="mb-20 bg-white">

    @include('components.navbar')


@php
    use Carbon\Carbon;
    // Cek apakah campaign sudah di-bookmark user
    $sudahBookmark = \DB::table('campaign_ditandai')
        ->where('akun_id', auth()->id())
        ->where('campaign_id', $campaign->id)
        ->exists();
@endphp

<div class="max-w-7xl mx-auto px-14 py-10">
    @if(is_null($campaign->nama))
        <div class="flex flex-col items-center justify-center min-h-[300px]">
            <svg xmlns="http://www.w3.org/2000/svg" class="h-16 w-16 text-gray-400 mb-4" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 13h6m2 7H7a2 2 0 01-2-2V7a2 2 0 012-2h5l2 2h5a2 2 0 012 2v10a2 2 0 01-2 2z" />
            </svg>
            <h2 class="text-2xl font-bold text-gray-700 mb-2">Campaign telah dihapus</h2>
            <p class="text-gray-500">Campaign ini sudah tidak tersedia.</p>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-16">
            <!-- Kolom kiri: Swiper + pagination -->
            <div class= "mt-10">
                <x-swiper-gallery :gambar="$campaign->gambar_campaign" />
                <p class="text-600 font-semibold mt-2">Lokasi Campaign</p>
                <p class="flex items-start text-gray-500 mt-2 text-[16px]">
                    <!-- Ikon Lokasi -->
                    <span class="flex-shrink-0">
                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5 mr-2 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                  d="M12 21c-4.418 0-8-5.373-8-10a8 8 0 1 1 16 0c0 4.627-3.582 10-8 10zm0-7a3 3 0 1 0 0-6 3 3 0 0 0 0 6z"/>
                    </span>
                    <span class="break-words">{{ $campaign->lokasi ?? '-' }}</span>
                </p>

            </div>
            <!-- Kolom kanan: Judul campaign -->
            <div>
                <div class="flex items-center mt-2 gap-4 justify-end">
                    <!-- Edit -->
                    <a href="{{ route('editcampaign', $campaign->id) }}" title="Edit Campaign">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                            viewBox="0 0 24 24" stroke="#74A740" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                            <path d="M13.5 6.5l4 4" />
                        </svg>
                    </a>
                    <!-- Hapus -->
                    <a href="#" onclick="confirmDeletion({{ $campaign->id }})" title="Hapus Campaign">
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none"
                            viewBox="0 0 24 24" stroke="#74A740" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                            <path d="M4 7l16 0" />
                            <path d="M10 11l0 6" />
                            <path d="M14 11l0 6" />
                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                        </svg>
                    </a>
                </div>
                <div class="flex items-center mb-2">
                    @if($campaign->akun && $campaign->akun->fotoProfil)
                        <img
                            src="{{ filter_var($campaign->akun->fotoProfil, FILTER_VALIDATE_URL)
                                ? $campaign->akun->fotoProfil
                                : asset('storage/' . $campaign->akun->fotoProfil) }}"
                            class="w-7 h-7 rounded-full"
                            alt="{{ $campaign->akun->namaPengguna }}"
                        />
                    @else
                        <img src="{{ asset('default-profile.png') }}" class="w-7 h-7 rounded-full" alt="Default Profile"/>
                    @endif
                    <p class="text-600 text-[18px] ml-5">{{ $campaign->akun->namaPengguna ?? '-' }}</p>

                </div>
                <div x-data="{
        bookmarked: {{ $sudahBookmark ? 'true' : 'false' }},
        showSuccess: false,
        toggleBookmark() {
            fetch(this.bookmarked ? '{{ route('campaign.unbookmark', $campaign->id) }}' : '{{ route('campaign.bookmark', $campaign->id) }}', {
                method: this.bookmarked ? 'DELETE' : 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            }).then(res => {
                if(res.ok) {
                    this.bookmarked = !this.bookmarked;
                    this.showSuccess = true;
                    setTimeout(() => this.showSuccess = false, 3000);
                }
            });
        }
    }" class="relative flex items-center gap-4 mb-2">
                    <h1 class="text-3xl font-bold text-gray-800 leading-snug flex-1 break-words">
                        {{ $campaign->nama }}
                    </h1>
                    <button
                        type="button"
                        class="focus:outline-none"
                        @click="toggleBookmark"
                        :title="bookmarked ? 'Hapus Bookmark' : 'Bookmark'"
                    >
                        <svg xmlns="http://www.w3.org/2000/svg"
                             :fill="bookmarked ? 'currentColor' : 'none'"
                             class="h-10 w-10 text-black transition-colors duration-200"
                             viewBox="0 0 24 24" stroke="currentColor" stroke-width="2">
                            <path stroke-linecap="round" stroke-linejoin="round"
                                  d="M5 5a2 2 0 0 1 2-2h10a2 2 0 0 1 2 2v16l-7-4-7 4V5z"/>
                        </svg>
                    </button>
                    <!-- Popup sukses -->
                    <div x-show="showSuccess" x-transition
                         class="absolute top-12 right-0 bg-green-500 text-white px-4 py-2 rounded shadow text-sm"
                         x-cloak>
                        <span x-text="bookmarked ? 'Berhasil ditambahkan ke favorit!' : 'Berhasil dihapus dari favorit!'"></span>
                    </div>
                </div>
                <div class="flex items-center text-[18px] text-600 mb-2 gap-6">
                    <span class="flex items-center">
                        <!-- Ikon Kalender -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-black" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <rect x="3" y="4" width="18" height="18" rx="2" stroke-width="2" stroke="currentColor"
                                fill="none" />
                            <path d="M16 2v4M8 2v4M3 10h18" stroke-width="2" stroke="currentColor" />
                        </svg>
                        {{ Carbon::parse($campaign->waktu)->format('d/m/Y') }}
                    </span>
                    <span class="flex items-center">
                        <!-- Ikon Jam -->
                        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5 mr-2 text-black" fill="none"
                            viewBox="0 0 24 24" stroke="currentColor">
                            <circle cx="12" cy="12" r="10" stroke-width="2" stroke="currentColor" fill="none" />
                            <path d="M12 6v6l4 2" stroke-width="2" stroke="currentColor" />
                        </svg>
                        {{ Carbon::parse($campaign->waktu)->format('H.i') }}
                    </span>
                </div>
                <p class="font-semibold mt-8 text-[16px]">Tentang Campaign</p>
                <p class="text-600 mt-2 text-[16px]">{{ $campaign->deskripsi }}</p>
                <p class="font-semibold mt-4 text-[16px]">Partisipan</p>
                <div class="flex items-center mt-2 min-h-[40px]">
                    @if($campaign->partisipanCampaigns->count() === 0)
                        <span class="text-gray-400 text-sm">Belum ada partisipan</span>
                    @else
                        @foreach($campaign->partisipanCampaigns->take(3) as $partisipan)
                            @if($partisipan->akun && $partisipan->akun->fotoProfil)
                                <img
                                    src="{{ filter_var($partisipan->akun->fotoProfil, FILTER_VALIDATE_URL)
                                        ? $partisipan->akun->fotoProfil
                                        : asset('storage/' . $partisipan->akun->fotoProfil) }}"
                                    class="w-8 h-8 rounded-full border-2 border-white shadow -ml-2 cursor-pointer"
                                    title="{{ $partisipan->nama }}"
                                    onclick="openModal()"
                                />
                            @endif
                        @endforeach
                        @if($campaign->partisipanCampaigns->count() > 3)
                            <span class="ml-2 text-sm text-gray-500">
                                +{{ $campaign->partisipanCampaigns->count() - 3 }}
                            </span>
                        @endif
                    @endif
                </div>

            </div>
        </div>
    @endif
</div>

{{-- Komentar --}}
<div class="mx-14 mt-8 mb-6 border border-gray-200 rounded-xl p-4">
    {{-- Form Komentar --}}
    @if(auth()->check())
        <form id="commentForm" class="flex items-center gap-3 mb-4" method="POST" action="{{ route('komentar.store', $campaign->id) }}">
            @csrf
            <img src="{{ filter_var(auth()->user()->fotoProfil, FILTER_VALIDATE_URL) ? auth()->user()->fotoProfil : asset('storage/' . auth()->user()->fotoProfil) }}" class="w-10 h-10 rounded-full">
            <div class="flex-1">
                <div class="font-semibold text-sm mb-1">{{ auth()->user()->namaPengguna }}</div>
                <input
                    id="commentInput"
                    name="komentar"
                    type="text"
                    class="w-full border-0 border-b border-gray-300 rounded-none px-0 py-2 text-sm focus:outline-none focus:ring-0 focus:border-[#74A740]"
                    placeholder="Tulis komentar kamu..."
                    autocomplete="off"
                    maxlength="280"
                    required
                >
            </div>
            <button type="submit" class="bg-[#74A740] text-white px-4 py-2 rounded-md hover:bg-red-800 transition">
                Kirim
            </button>
        </form>
    @endif
</div>
<div class="mx-14" id="commentsSection">
    <h3 class="font-semibold text-lg mb-4 text-gray-700">Komentar</h3>
    <x-list-komentar :komentar="$komentar" :campaign="$campaign" />
</div>
<!-- Modal Overlay -->
    <div id="popupModal" class="hidden fixed inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center z-50">
        <!-- Modal Content -->
        <div class="bg-white rounded-lg shadow-lg max-w-md w-full p-6 relative">
            <!-- Close Button -->
            <button onclick="toggleModal()" class="absolute top-2 right-2 text-gray-500 hover:text-black">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6" fill="none"
                    viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>

            <h2 class="text-xl font-bold mb-4">Daftar Partisipan</h2>
            <ul class="space-y-2 max-h-60 overflow-y-auto">
                @forelse ($campaign->partisipanCampaigns as $partisipan)
                    <li class="flex items-center gap-3">
                        @if($partisipan->akun && $partisipan->akun->fotoProfil)
                            <img src="{{ filter_var($partisipan->akun->fotoProfil, FILTER_VALIDATE_URL)
                                ? $partisipan->akun->fotoProfil
                                : asset('storage/' . $partisipan->akun->fotoProfil) }}"
                                class="w-8 h-8 rounded-full border" alt="{{ $partisipan->nama }}">
                        @else
                            <img src="{{ asset('default-profile.png') }}" class="w-8 h-8 rounded-full border" alt="Default Profile">
                        @endif
                        <span>{{ $partisipan->nama }}</span>
                    </li>
                @empty
                    <li class="text-gray-500">Belum ada partisipan.</li>
                @endforelse
            </ul>
        </div>
    </div>

<script>
function confirmDeletion(campaignId) {
    Swal.fire({
        title: 'Apakah Anda yakin ingin menghapus campaign?',
        html: '<span>Semua data campaign dan seluruh partisipan akan dihapus dari campaign.</span>',
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#74A740',
        cancelButtonColor: '#b0b0b0',
        confirmButtonText: 'Ya',
        cancelButtonText: 'Batal',
        customClass: {
            popup: 'rounded-xl',
            confirmButton: 'rounded-3xl px-6 py-2',
            cancelButton: 'rounded-3xl px-6 py-2'
        }
    }).then((result) => {
        if (result.isConfirmed) {
            window.location.href = "{{ route('campaign.nullify', ':id') }}".replace(':id', campaignId);
        }
    });
}

function openModal() {
            const modal = document.getElementById('popupModal');
            modal.classList.remove('hidden');
        }

        function toggleModal() {
            const modal = document.getElementById('popupModal');
            modal.classList.add('hidden');
        }
</script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function attachCommentEvents() {
        document.querySelectorAll('.menu-toggle-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.stopPropagation();
                const id = btn.getAttribute('data-id');
                const popup = document.getElementById('menu-popup-' + id);
                document.querySelectorAll('.menu-popup').forEach(function(p) {
                    if (p !== popup) p.classList.add('hidden');
                });
                popup.classList.toggle('hidden');
            };
        });

        document.querySelectorAll('.edit-comment-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.stopPropagation();
                btn.closest('.menu-popup').classList.add('hidden');
                const id = btn.getAttribute('data-id');
                const commentDiv = btn.closest('.flex-1');
                const textDiv = commentDiv.querySelector('.text-sm.text-gray-700');
                const oldText = textDiv.textContent.trim();
                if (commentDiv.querySelector('.edit-comment-form')) return;
                const form = document.createElement('form');
                form.className = 'edit-comment-form flex gap-2 mt-1';
                form.innerHTML = `
                    <input type="text" class="border rounded px-2 py-1 text-sm flex-1" value="${oldText}" maxlength="280" required>
                    <button type="submit" class="bg-[#74A740] text-white px-3 py-1 rounded text-xs">Kirim</button>
                    <button type="button" class="cancel-edit text-gray-500 px-2 text-xs">Batal</button>
                `;
                textDiv.style.display = 'none';
                textDiv.parentNode.insertBefore(form, textDiv);
                form.querySelector('.cancel-edit').onclick = function() {
                    form.remove();
                    textDiv.style.display = '';
                };
                form.onsubmit = function(ev) {
                    ev.preventDefault();
                    const newText = form.querySelector('input').value.trim();
                    if (!newText) return;
                    fetch(`/komentar/${id}`, {
                        method: 'PATCH',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                            'Content-Type': 'application/json'
                        },
                        body: JSON.stringify({ komentar: newText })
                    })
                    .then(res => res.json())
                    .then(data => {
                        if (data.success) {
                            textDiv.textContent = data.komentar.komentar;
                            const waktuSpan = commentDiv.querySelector('.waktu-komentar');
                            if (waktuSpan) waktuSpan.innerHTML = '• ' + data.komentar.updated_at + ' <span class="text-xs text-gray-400">(Edited)</span>';
                            form.remove();
                            textDiv.style.display = '';
                        } else {
                            alert(data.message || 'Gagal update komentar.');
                        }
                    });
                };
            };
        });

        document.querySelectorAll('.delete-comment-btn').forEach(function(btn) {
            btn.onclick = function(e) {
                e.stopPropagation();
                btn.closest('.menu-popup').classList.add('hidden');
                const id = btn.getAttribute('data-id');
                fetch(`/komentar/${id}`, {
                    method: 'DELETE',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                        'Content-Type': 'application/json'
                    }
                })
                .then(res => res.json())
                .then(data => {
                    if (data.success) {
                        btn.closest('.flex.items-start').remove();
                        const notif = document.getElementById('notif-delete-comment');
                        if (notif) {
                            notif.classList.remove('hidden');
                            setTimeout(() => notif.classList.add('hidden'), 2000);
                        }
                    } else {
                        alert(data.message || 'Gagal hapus komentar.');
                    }
                });
            };
        });
    }

    // AJAX untuk submit komentar
    const form = document.getElementById('commentForm');
    if (form) {
        form.addEventListener('submit', function(e) {
            e.preventDefault();
            const input = document.getElementById('commentInput');
            const komentar = input.value.trim();
            if (!komentar) return;

            fetch(form.action, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify({ komentar })
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const k = data.komentar;
                    const isOwner = k.akun_id == {{ auth()->id() }};
                    let menuHtml = '';
                    if (isOwner) {
                        menuHtml = `
                            <div class="relative">
                                <button
                                    type="button"
                                    class="p-1 rounded hover:bg-gray-100 focus:outline-none menu-toggle-btn"
                                    title="Menu"
                                    data-id="${k.id}"
                                    id="menu-btn-${k.id}"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                        <circle cx="12" cy="6" r="1.5" fill="#171717"/>
                                        <circle cx="12" cy="12" r="1.5" fill="#171717"/>
                                        <circle cx="12" cy="18" r="1.5" fill="#171717"/>
                                    </svg>
                                </button>
                                <div
                                    class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow z-10 menu-popup"
                                    id="menu-popup-${k.id}"
                                >
                                    <button type="button" class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm hover:bg-gray-100 edit-comment-btn" data-id="${k.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="#171717" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                        Edit Komentar
                                    </button>
                                    <button type="button" class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm hover:bg-gray-100 text-red-600 delete-comment-btn" data-id="${k.id}">
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="red" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 7l16 0" />
                                            <path d="M10 11l0 6" />
                                            <path d="M14 11l0 6" />
                                            <path d="M5 7l1 12a2 2 0 0 0 2 2h8a2 2 0 0 0 2 -2l1 -12" />
                                            <path d="M9 7v-3a1 1 0 0 1 1 -1h4a1 1 0 0 1 1 1v3" />
                                        </svg>
                                        Hapus Komentar
                                    </button>
                                </div>
                            </div>
                        `;
                    }
                    const html = `
                        <div class="flex items-start mb-4">
                            <img src="${k.fotoProfil}" class="w-10 h-10 rounded-full mr-3" alt="Avatar">
                            <div class="flex-1">
                                <div class="flex items-center justify-between">
                                    <div>
                                        <span class="font-semibold text-sm">${k.namaPengguna}</span>
                                        <span class="text-xs text-gray-400 waktu-komentar">• ${k.updated_at}</span>
                                    </div>
                                    ${menuHtml}
                                </div>
                                <div class="text-sm text-gray-700 mb-1">${k.komentar}</div>
                                <button
                                    type="button"
                                    class="like-btn mt-1 text-xs flex items-center gap-1"
                                    data-id="${k.id}"
                                    data-liked="0"
                                >
                                    <svg xmlns="http://www.w3.org/2000/svg"
                                         viewBox="0 0 24 24"
                                         class="w-5 h-5 transition-colors duration-200"
                                         fill="none"
                                         stroke="#171717"
                                         stroke-width="1.5">
                                    <path stroke-linecap="round" stroke-linejoin="round"
                                          d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                                </svg>
                                <span class="like-count text-[#171717]">0</span>
                            </button>
                        </div>
                    </div>
                `;
                    document.getElementById('commentsList').insertAdjacentHTML('afterbegin', html);
                    input.value = '';
                    attachCommentEvents();
                } else {
                    alert('Gagal menambah komentar.');
                }
            })
            .catch(() => alert('Gagal menambah komentar (server error).'));
        });
    }

    // Like event delegation tetap
    document.getElementById('commentsList').addEventListener('click', function(e) {
        const btn = e.target.closest('.like-btn');
        if (!btn) return;
        const komentarId = btn.getAttribute('data-id');
        fetch(`/komentar/${komentarId}/like`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}',
                'Accept': 'application/json',
                'Content-Type': 'application/json'
            }
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                const svg = btn.querySelector('svg');
                svg.setAttribute('fill', data.liked ? 'red' : 'none');
                svg.setAttribute('stroke', data.liked ? 'red' : '#171717');
                btn.setAttribute('data-liked', data.liked ? '1' : '0');
                btn.querySelector('.like-count').textContent = data.count;
            } else {
                alert(data.message || 'Tidak bisa like komentar.');
            }
        });
    });

    // Panggil sekali di awal
    attachCommentEvents();
});
</script>
</body>

</html>
