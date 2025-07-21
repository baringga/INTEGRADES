<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProfilController extends Controller
{
    public function show()
    {
        $user = Auth::user();

        if (!$user) {
            return redirect()->route('login');
        }

        // Arahkan ke controller yang sesuai berdasarkan peran
        if ($user->jenis_akun_id == 1) { // Asumsi 1 = Volunteer Desa
            return app(\App\Http\Controllers\ProfilVolunteerController::class)->show();
        } elseif ($user->jenis_akun_id == 2) { // Asumsi 2 = Masyarakat Desa
            // Nanti kita buat controller untuk Masyarakat Desa
            // Untuk sekarang, kita bisa arahkan ke view sederhana
            return view('profilmasyarakat', compact('user'));
        } else {
            abort(403, 'Tipe akun tidak dikenali.');
        }
    }

    public function update(\Illuminate\Http\Request $request)
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
            'portofolio' => 'nullable|url|max:1000', // Validasi portofolio sebagai URL
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

        // Update portofolio jika pengguna adalah Volunteer Desa
        if ($user->jenis_akun_id == 1 && $request->filled('portofolio')) {
            \App\Models\AkunKomunitas::updateOrCreate(
                ['akun_id' => $user->id],
                ['portofolio' => $request->portofolio]
            );
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
