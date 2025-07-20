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

        if ($user->jenis_akun_id == 1) {
            // Volunteer
            return app(\App\Http\Controllers\ProfilVolunteerController::class)->show();
        } elseif ($user->jenis_akun_id == 2) {
            // Community
            return app(\App\Http\Controllers\ProfilCommunityController::class)->show();
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
            'portofolio' => 'nullable|string|max:1000',
        ]);

        // Update foto profil jika ada
        if ($request->hasFile('fotoProfil')) {
            $file = $request->file('fotoProfil');
            $path = $file->store('foto_profil', 'public');
            $user->fotoProfil = $path;
        }

        $user->namaPengguna = $request->namaPengguna;
        $user->email = $request->email;
        $user->nomorTelepon = $request->nomorTelepon;
        $user->updated_at = now();
        $user->save();

        // Update portofolio komunitas jika user komunitas
        if ($user->jenis_akun_id == 2 && $request->has('portofolio')) {
            \App\Models\AkunKomunitas::updateOrCreate(
                ['akun_id' => $user->id],
                ['portofolio' => $request->portofolio]
            );
        }

        return back()->with('success', 'Profil berhasil diperbarui!');
    }
}
