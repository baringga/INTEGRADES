<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Komentar;

class KomentarController extends Controller
{
    public function store(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:280',
        ]);

        $komentar = Komentar::create([
            'akun_id' => Auth::id(),
            'campaign_id' => $id,
            'komentar' => $request->komentar,
            'waktu' => now(),
            'updated_at' => now(),
        ]);

        $komentar = Komentar::with(['akun', 'likes'])->find($komentar->id);

        return response()->json([
            'success' => true,
            'komentar' => [
                'id' => $komentar->id,
                'namaPengguna' => $komentar->akun?->namaPengguna ?? '-',
                'fotoProfil' => $komentar->akun?->fotoProfil ? (filter_var($komentar->akun->fotoProfil, FILTER_VALIDATE_URL) ? $komentar->akun->fotoProfil : asset('storage/' . $komentar->akun->fotoProfil)) : asset('default-profile.png'),
                'komentar' => $komentar->komentar,
                'updated_at' => $komentar->updated_at->diffForHumans(),
                'akun_id' => $komentar->akun_id,
                'likes_count' => $komentar->likes->count(),
            ]
        ]);
    }

    public function like($id, Request $request)
    {
        $user = auth()->user();
        $komentar = Komentar::findOrFail($id);

        // Cek apakah user sudah like
        $liked = $komentar->likes()->where('akun_id', $user->id)->exists();

        if ($liked) {
            // Unlike
            $komentar->likes()->detach($user->id);
        } else {
            // Like
            $komentar->likes()->attach($user->id);
        }

        return response()->json([
            'success' => true,
            'liked' => !$liked,
            'count' => $komentar->likes()->count(),
        ]);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'komentar' => 'required|string|max:280',
        ]);

        $komentar = Komentar::findOrFail($id);

        // Pastikan hanya pemilik komentar yang bisa edit
        if ($komentar->akun_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        $komentar->komentar = $request->komentar;
        $komentar->updated_at = now();
        $komentar->save();

        return response()->json([
            'success' => true,
            'komentar' => [
                'id' => $komentar->id,
                'komentar' => $komentar->komentar,
                'updated_at' => $komentar->updated_at->diffForHumans(),
            ]
        ]);
    }

    public function destroy($id)
    {
        $komentar = \App\Models\Komentar::findOrFail($id);

        // Ambil campaign terkait komentar
        $campaign = \App\Models\Campaign::find($komentar->campaign_id);

        // Boleh hapus jika: pemilik komentar ATAU pemilik campaign
        if (
            $komentar->akun_id !== auth()->id() &&
            (!$campaign || $campaign->akun_id !== auth()->id())
        ) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 403);
        }

        // Hapus semua like terkait komentar ini
        \DB::table('komentar_disukai')->where('komentar_id', $id)->delete();

        // Hapus komentar
        $komentar->delete();

        return response()->json(['success' => true]);
    }
}