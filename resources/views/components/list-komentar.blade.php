{{-- List Komentar --}}
<div id="commentsList">
    @php
        // Kirim $campaign dari blade utama ke komponen ini (pastikan dikirim!)
        $isOwner = isset($campaign) && auth()->id() === $campaign->akun_id;
    @endphp
    @forelse($komentar as $k)
        <div class="flex items-start mb-4">
            <img src="{{ filter_var($k->akun->fotoProfil, FILTER_VALIDATE_URL) ? $k->akun->fotoProfil : asset('storage/' . $k->akun->fotoProfil) }}"
                 class="w-10 h-10 rounded-full mr-3" alt="Avatar">
            <div class="flex-1">
                <div class="flex items-center justify-between">
                    <div>
                        <span class="font-semibold text-sm">{{ $k->akun?->namaPengguna ?? '-' }}</span>
                        <span class="text-xs text-gray-400 waktu-komentar">• {{ $k->updated_at->diffForHumans() }}@if($k->updated_at && $k->updated_at->ne($k->waktu)) <span class=" text-xs text-gray-400">(Edited)</span>@endif</span>
                    </div>
                    @if($isOwner || auth()->id() === $k->akun_id)
                        <div class="relative">
                            <button
                                type="button"
                                class="p-1 rounded hover:bg-gray-100 focus:outline-none menu-toggle-btn"
                                title="Menu"
                                data-id="{{ $k->id }}"
                                id="menu-btn-{{ $k->id }}"
                            >
                                <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none" viewBox="0 0 24 24">
                                    <circle cx="12" cy="6" r="1.5" fill="#171717"/>
                                    <circle cx="12" cy="12" r="1.5" fill="#171717"/>
                                    <circle cx="12" cy="18" r="1.5" fill="#171717"/>
                                </svg>
                            </button>
                            <div
                                class="hidden absolute right-0 mt-2 w-48 bg-white border border-gray-200 rounded shadow z-10 menu-popup"
                                id="menu-popup-{{ $k->id }}"
                            >
                                @if($isOwner && auth()->id() !== $k->akun_id)
                                    {{-- Pemilik campaign, tapi bukan komentarnya sendiri: hanya hapus --}}
                                    <button type="button" class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm hover:bg-gray-100 text-red-600 delete-comment-btn" data-id="{{ $k->id }}">
                                        <!-- Ikon tong sampah -->
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
                                @elseif(auth()->id() === $k->akun_id)
                                    {{-- Komentar milik sendiri: edit & hapus --}}
                                    <button type="button" class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm hover:bg-gray-100 edit-comment-btn" data-id="{{ $k->id }}">
                                        <!-- Ikon pensil -->
                                        <svg xmlns="http://www.w3.org/2000/svg" class="w-5 h-5" fill="none"
                                             viewBox="0 0 24 24" stroke="#171717" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round">
                                            <path d="M4 20h4l10.5 -10.5a2.828 2.828 0 1 0 -4 -4l-10.5 10.5v4" />
                                            <path d="M13.5 6.5l4 4" />
                                        </svg>
                                        Edit Komentar
                                    </button>
                                    <button type="button" class="w-full flex items-center gap-2 text-left px-4 py-3 text-sm hover:bg-gray-100 text-red-600 delete-comment-btn" data-id="{{ $k->id }}">
                                        <!-- Ikon tong sampah -->
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
                                @endif
                            </div>
                        </div>
                    @endif
                </div>
                <div class="text-sm text-gray-700 mb-1">{{ $k->komentar }}</div>
                <button
                    type="button"
                    class="like-btn mt-1 text-xs flex items-center gap-1"
                    data-id="{{ $k->id }}"
                    data-liked="{{ isset($k->likes) && $k->likes->contains(auth()->id()) ? '1' : '0' }}"
                >
                    @php
                        $liked = isset($k->likes) && $k->likes->contains(auth()->id());
                    @endphp
                    <svg xmlns="http://www.w3.org/2000/svg"
                         viewBox="0 0 24 24"
                         class="w-5 h-5 transition-colors duration-200"
                         fill="{{ $liked ? 'red' : 'none' }}"
                         stroke="{{ $liked ? 'red' : '#171717' }}"
                         stroke-width="1.5">
                        <path stroke-linecap="round" stroke-linejoin="round"
                              d="M4.318 6.318a4.5 4.5 0 016.364 0L12 7.636l1.318-1.318a4.5 4.5 0 116.364 6.364L12 21.364l-7.682-7.682a4.5 4.5 0 010-6.364z" />
                    </svg>
                    <span class="like-count text-[#171717]">{{ isset($k->likes) ? $k->likes->count() : 0 }}</span>
                </button>
            </div>
        </div>
    @empty
    @endforelse
</div>

<div id="notif-delete-comment" class="fixed left-1/2 -translate-x-1/2 bottom-6 z-50 bg-green-600 text-white px-4 py-2 rounded shadow-lg text-sm hidden">
    Komentar berhasil dihapus.
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    function attachCommentEvents() {
        // Menu titik tiga
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

        // Edit komentar
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

        // Hapus komentar
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

    attachCommentEvents();
});
</script>
