<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelola Partisipan - {{ $campaign->nama }}</title>
    @vite('resources/css/app.css')
</head>
<body class="bg-gray-50 mb-20">
    @include('components.navbar')

    <main class="max-w-6xl mx-auto py-10 px-4">
        <div class="mb-8 border-b pb-4">
            <h1 class="text-3xl font-bold text-gray-800">Kelola Partisipan</h1>
            <p class="text-gray-600 mt-1">Anda sedang mengelola pendaftar untuk campaign: <span class="font-semibold">{{ $campaign->nama }}</span></p>
        </div>

        @if(session('success'))
            <div class="bg-green-100 text-green-800 p-4 rounded-lg mb-4" role="alert">{{ session('success') }}</div>
        @endif
        @if(session('error'))
            <div class="bg-red-100 text-red-700 p-4 rounded-lg mb-4" role="alert">{{ session('error') }}</div>
        @endif

        <div class="bg-white p-6 rounded-lg border border-gray-200">
            <div class="overflow-x-auto">
                <table class="min-w-full divide-y divide-gray-200">
                    <thead class="bg-gray-50">
                        <tr>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nama Pendaftar</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Email</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Status</th>
                            <th scope="col" class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Aksi</th>
                        </tr>
                    </thead>
                    <tbody class="bg-white divide-y divide-gray-200">
                        @foreach ($campaign->partisipanCampaigns as $partisipan)
                        <tr>
                            <td class="border px-4 py-2">{{ $partisipan->akun->namaPengguna }}</td>
                            <td class="border px-4 py-2">{{ $partisipan->akun->email }}</td>
                            <td class="border px-4 py-2">
                                @if($partisipan->status == 'approved')
                                    <span class="text-green-600">Disetujui</span>
                                @elseif($partisipan->status == 'rejected')
                                    <span class="text-red-600">Ditolak</span>
                                @else
                                    <span class="text-yellow-600">Pending</span>
                                @endif
                            </td>
                            <td class="border px-4 py-2">
                                @if($partisipan->status == 'pending')
                                <form action="{{ route('partisipan.updateStatus', $partisipan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="approved">
                                    <button type="submit" class="text-green-600">Setujui</button>
                                </form>
                                <form action="{{ route('partisipan.updateStatus', $partisipan->id) }}" method="POST" style="display:inline;">
                                    @csrf
                                    <input type="hidden" name="status" value="rejected">
                                    <button type="submit" class="text-red-600">Tolak</button>
                                </form>
                                @else
                                <span class="text-gray-400">Selesai</span>
                                @endif
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>

        @if(Auth::id() === $campaign->akun_id)
            <a href="{{ route('campaign.manage', $campaign->id) }}" class="btn bg-[#74A740] text-white rounded-lg px-4 py-2">Kelola Partisipan</a>
        @endif
    </main>
</body>
</html>
