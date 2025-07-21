<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan;
use App\Models\AkunKomunitas;

class ProfilController extends Controller
{
    /**
     * Menampilkan halaman profil yang sesuai berdasarkan peran pengguna.
     */
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        $pengaduanSaya = Pengaduan::where('akun_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        if ($user->jenis_akun_id == 1) { // 1 = Volunteer Desa
            return app(\App\Http\Controllers\ProfilVolunteerController::class)->show($pengaduanSaya);
        } elseif ($user->jenis_akun_id == 2) { // 2 = Masyarakat Desa
            return view('profilmasyarakat', [
                'user' => $user,
                'pengaduanSaya' => $pengaduanSaya
            ]);
        } else {
            abort(403, 'Tipe akun tidak dikenali.');
        }
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Update data user
        $user->namaPengguna = $request->namaPengguna;
        $user->email = $request->email;
        $user->nomorTelepon = $request->nomorTelepon;
        // ...update foto profil jika ada...

        $user->save();

        return back()->with('success', 'Profil berhasil diperbarui!');
    }

    /**
     * Menampilkan semua pengaduan yang dibuat oleh pengguna (halaman "Lihat Semua").
     */
    public function laporanSaya()
    {
        $user = Auth::user();

        $pengaduanSaya = Pengaduan::where('akun_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->paginate(10); // Menggunakan paginate untuk halaman ini

        return view('profil.laporan-saya', [
            'pengaduanSaya' => $pengaduanSaya
        ]);
    }
}
