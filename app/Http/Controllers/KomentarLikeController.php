<?php
namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Komentar;

class KomentarLikeController extends Controller
{
    public function toggle(Request $request, $id)
    {
        $user = auth()->user();
        $role = $request->input('role'); // 'volunteer' atau 'komunitas'

        // Validasi role
        if ($role === 'volunteer' && $user->jenis_akun_id != 1) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya volunteer yang bisa like komentar di halaman ini.'
            ], 403);
        }
        if ($role === 'komunitas' && $user->jenis_akun_id != 2) {
            return response()->json([
                'success' => false,
                'message' => 'Hanya komunitas yang bisa like komentar di halaman ini.'
            ], 403);
        }

        $komentar = Komentar::findOrFail($id);

        if ($komentar->likes()->where('akun_id', $user->id)->exists()) {
            $komentar->likes()->detach($user->id);
            $liked = false;
        } else {
            $komentar->likes()->attach($user->id);
            $liked = true;
        }

        return response()->json([
            'success' => true,
            'liked' => $liked,
            'count' => $komentar->likes()->count(),
        ]);
    }
}