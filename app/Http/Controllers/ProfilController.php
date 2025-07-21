<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Pengaduan; // Tambahkan ini untuk mengakses model Pengaduan
use App\Models\AkunKomunitas; // Diperlukan untuk update portofolio

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

        // Ambil data pengaduan yang dibuat oleh user ini
        $pengaduanSaya = Pengaduan::where('akun_id', $user->id)
                                  ->orderBy('created_at', 'desc')
                                  ->get();

        if ($user->jenis_akun_id == 1) { // 1 = Volunteer Desa
            // Di tahap selanjutnya, kita akan mengirimkan data pengaduan ini ke ProfilVolunteerController
            return app(\App\Http\Controllers\ProfilVolunteerController::class)->show($pengaduanSaya);
        } elseif ($user->jenis_akun_id == 2) { // 2 = Masyarakat Desa
            // Kirim data user dan data pengaduannya ke view
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
        $user = auth()->user();
        $request->validate([
            'namaPengguna' => 'required|string|max:100',
            'email' => [
                'required',
                'email',
                'max:100',
                'unique:akun,email,' . $user->id,
                'regex:/^[a-zA-Z0-9._%+-]+@gmail\.com$/'
            ],
            'nomorTelepon' => 'required|string|max:20',
            'fotoProfil' => 'nullable|image|mimes:jpeg,png,jpg,svg,gif|max:2048',
            'portofolio' => 'nullable|url|max:1000',
        ]);

        if ($request->hasFile('fotoProfil')) {
            $path = $request->file('fotoProfil')->store('foto_profil', 'public');
            $user->fotoProfil = $path;
        }

        $user->namaPengguna = $request->namaPengguna;
        $user->email = $request->email;
        $user->nomorTelepon = $request->nomorTelepon;
        $user->updated_at = now();
        $user->save();

        // Update portofolio jika pengguna adalah Volunteer Desa (ID 1)
        if ($user->jenis_akun_id == 1 && $request->filled('portofolio')) {
            AkunKomunitas::updateOrCreate(
                ['akun_id' => $user->id],
                ['portofolio' => $request->portofolio]
            );
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
