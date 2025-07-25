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
        $user = auth()->user();
        $campaignsDiikuti = $user->campaignsDiikuti()->latest()->get();
        $campaigns = $user->campaigns()->latest()->get(); // campaign yang dibuat user
        $pengaduanSaya = $user->pengaduan()->latest()->get();
        $komentarList = $user->komentar()->latest()->get();

        return view('profilvolunteer', compact('user', 'campaignsDiikuti', 'campaigns', 'pengaduanSaya', 'komentarList'));
    }

    /**
     * Memperbarui informasi profil pengguna.
     */
    public function update(Request $request)
    {
        $user = Auth::user();

        // Jika ada upload foto
        if ($request->hasFile('fotoProfil')) {
            $path = $request->file('fotoProfil')->store('foto', 'public');
            $user->fotoProfil = $path;
        }

        // Update data lain
        $user->namaPengguna = $request->namaPengguna;
        $user->email = $request->email;
        $user->nomorTelepon = $request->nomorTelepon;
        $user->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
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
